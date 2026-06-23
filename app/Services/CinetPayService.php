<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Mail\SubscriptionConfirmedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CinetPayService
{
    protected string $apikey;
    protected string $siteId;
    protected string $secretKey;
    protected string $notifyUrl;
    protected string $returnUrl;
    protected string $currency;

    public function __construct()
    {
        $this->apikey = config('cinetpay.apikey');
        $this->siteId = config('cinetpay.site_id');
        $this->secretKey = config('cinetpay.secret_key');
        $this->notifyUrl = config('cinetpay.notify_url');
        $this->returnUrl = config('cinetpay.return_url');
        $this->currency = config('cinetpay.currency');
    }

    /**
     * Initie un paiement via CinetPay.
     */
    public function initiatePayment(User $user, SubscriptionPlan $plan): array
    {
        $transactionId = uniqid('insp', true);
        $transactionId = preg_replace('/[^a-zA-Z0-9]/', '', $transactionId);

        $amount = (int) $plan->price;

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'status' => 'pending',
            'cinetpay_transaction_id' => $transactionId,
        ]);

        Payment::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'transaction_id' => $transactionId,
            'amount' => $amount,
            'currency' => $this->currency,
            'status' => 'pending',
        ]);

        $payload = [
            'apikey' => $this->apikey,
            'site_id' => $this->siteId,
            'transaction_id' => $transactionId,
            'amount' => $amount,
            'currency' => $this->currency,
            'description' => "Abonnement {$plan->name} - Inspira",
            'customer_id' => (string) $user->id,
            'customer_name' => $user->name,
            'customer_surname' => '',
            'customer_email' => $user->email,
            'customer_phone_number' => $user->phone ?? '',
            'notify_url' => $this->notifyUrl,
            'return_url' => $this->returnUrl,
            'channels' => 'ALL',
            'metadata' => json_encode(['subscription_id' => $subscription->id]),
        ];

        $response = Http::timeout(30)
            ->post('https://api-checkout.cinetpay.com/v2/payment', $payload);

        if (!$response->successful()) {
            Log::error('CinetPay initiatePayment failed', [
                'transaction_id' => $transactionId,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \RuntimeException('Échec de l\'initiation du paiement CinetPay.');
        }

        $body = $response->json();

        if (($body['code'] ?? '') !== '201') {
            Log::error('CinetPay initiatePayment unexpected response', [
                'transaction_id' => $transactionId,
                'response' => $body,
            ]);
            throw new \RuntimeException($body['message'] ?? 'Réponse inattendue de CinetPay.');
        }

        return [
            'payment_url' => $body['data']['payment_url'] ?? '',
            'transaction_id' => $transactionId,
            'payment_token' => $body['data']['payment_token'] ?? '',
        ];
    }

    /**
     * Vérifie le statut d'une transaction auprès de CinetPay.
     */
    public function verifyTransaction(string $transactionId): array
    {
        $response = Http::timeout(15)
            ->post('https://api-checkout.cinetpay.com/v2/payment/check', [
                'apikey' => $this->apikey,
                'site_id' => $this->siteId,
                'transaction_id' => $transactionId,
            ]);

        if (!$response->successful()) {
            Log::error('CinetPay verifyTransaction failed', [
                'transaction_id' => $transactionId,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \RuntimeException('Échec de la vérification du paiement CinetPay.');
        }

        return $response->json();
    }

    /**
     * Traite la notification webhook de CinetPay.
     * NE JAMAIS faire confiance au body reçu — toujours rappeler verifyTransaction().
     */
    public function handleWebhookNotification(Request $request): void
    {
        $transactionId = $request->input('cpm_trans_id');

        if (!$transactionId) {
            Log::warning('CinetPay webhook reçu sans cpm_trans_id');
            return;
        }

        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (!$payment) {
            Log::warning('CinetPay webhook : transaction inconnue', [
                'transaction_id' => $transactionId,
            ]);
            return;
        }

        if ($payment->status === 'accepted') {
            Log::info('CinetPay webhook : paiement déjà traité', [
                'transaction_id' => $transactionId,
            ]);
            return;
        }

        $verification = $this->verifyTransaction($transactionId);

        $code = $verification['code'] ?? '';
        $status = $verification['data']['status'] ?? '';

        $payment->update([
            'cinetpay_payment_token' => $request->input('token'),
            'raw_response' => $verification,
        ]);

        if ($code === '201' && $status === 'ACCEPTED') {
            $payment->update([
                'status' => 'accepted',
                'payment_method' => $verification['data']['payment_method'] ?? null,
                'paid_at' => now(),
            ]);

            $subscription = $payment->subscription;

            if ($subscription) {
                $activeSub = Subscription::where('user_id', $subscription->user_id)
                    ->where('status', 'active')
                    ->where('expires_at', '>', now())
                    ->latest('expires_at')
                    ->first();

                if ($activeSub) {
                    $expiresAt = $activeSub->expires_at->addDays($subscription->plan->duration_in_days);
                    $activeSub->update([
                        'expires_at' => $expiresAt,
                    ]);
                    $subscription->update(['status' => 'cancelled']);
                } else {
                    $subscription->update([
                        'status' => 'active',
                        'started_at' => now(),
                        'expires_at' => now()->addDays($subscription->plan->duration_in_days),
                    ]);
                }

                try {
                    Mail::to($subscription->user)->send(new SubscriptionConfirmedMail($subscription));
                } catch (\Throwable $e) {
                    Log::error('Erreur envoi email confirmation abonnement', [
                        'subscription_id' => $subscription->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        } elseif ($code === '201' && $status === 'REFUSED') {
            $payment->update(['status' => 'refused']);
        }
    }
}

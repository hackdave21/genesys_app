<?php

namespace App\Http\Controllers\Inspira;

use App\Http\Controllers\Controller;
use App\Services\CinetPayService;
use Illuminate\Http\Request;

class CinetPayController extends Controller
{
    public function __construct(
        protected CinetPayService $cinetPay
    ) {}

    /**
     * Webhook CinetPay (POST, CSRF exempt).
     */
    public function notify(Request $request)
    {
        $this->cinetPay->handleWebhookNotification($request);

        return response('OK', 200);
    }

    /**
     * Page de retour après paiement CinetPay.
     */
    public function return(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');

        if ($transactionId && $status === 'ACCEPTED') {
            return redirect()->route('inspira.dashboard')
                ->with('success', 'Votre abonnement a été activé avec succès !');
        }

        if ($transactionId && $status === 'REFUSED') {
            return redirect()->route('inspira.tarifs')
                ->withErrors(['payment' => 'Le paiement a été refusé. Veuillez réessayer.']);
        }

        return redirect()->route('inspira.tarifs')
            ->with('success', 'Votre paiement est en cours de traitement. Vous recevrez un email de confirmation.');
    }
}

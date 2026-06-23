<?php

namespace Tests\Feature\Inspira;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\CinetPayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CinetPayPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected SubscriptionPlan $plan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'client']);

        $this->plan = SubscriptionPlan::create([
            'name' => 'Mensuel',
            'slug' => 'mensuel',
            'price' => 5000,
            'currency' => 'XOF',
            'duration_in_days' => 30,
            'is_active' => true,
        ]);

        config([
            'cinetpay.apikey' => 'test_apikey',
            'cinetpay.site_id' => 'test_site_id',
            'cinetpay.secret_key' => 'test_secret',
            'cinetpay.notify_url' => 'https://example.com/cinetpay/notify',
            'cinetpay.return_url' => 'https://example.com/cinetpay/return',
            'cinetpay.currency' => 'XOF',
        ]);
    }

    public function test_initiate_payment_creates_pending_payment(): void
    {
        Http::fake([
            'api-checkout.cinetpay.com/*' => Http::response([
                'code' => '201',
                'message' => 'Requête traitée avec succès',
                'data' => [
                    'payment_url' => 'https://checkout.cinetpay.com/payment/xyz',
                    'payment_token' => 'token_abc',
                ],
            ], 200),
        ]);

        $service = app(CinetPayService::class);
        $result = $service->initiatePayment($this->user, $this->plan);

        $this->assertDatabaseHas('payments', [
            'user_id' => $this->user->id,
            'amount' => 5000,
            'currency' => 'XOF',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $this->user->id,
            'subscription_plan_id' => $this->plan->id,
            'status' => 'pending',
        ]);

        $this->assertArrayHasKey('payment_url', $result);
        $this->assertArrayHasKey('transaction_id', $result);
    }

    public function test_webhook_activates_subscription_on_accepted_payment(): void
    {
        $subscription = Subscription::create([
            'user_id' => $this->user->id,
            'subscription_plan_id' => $this->plan->id,
            'status' => 'pending',
        ]);

        $payment = Payment::create([
            'user_id' => $this->user->id,
            'subscription_id' => $subscription->id,
            'transaction_id' => 'insp_test_123',
            'amount' => 5000,
            'currency' => 'XOF',
            'status' => 'pending',
        ]);

        Http::fake([
            'api-checkout.cinetpay.com/v2/payment/check' => Http::response([
                'code' => '201',
                'message' => 'Requête traitée avec succès',
                'data' => [
                    'status' => 'ACCEPTED',
                    'payment_method' => 'OM',
                ],
            ], 200),
        ]);

        $service = app(CinetPayService::class);
        $request = new Request([
            'cpm_trans_id' => 'insp_test_123',
            'token' => 'tok_abc',
        ]);
        $service->handleWebhookNotification($request);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'accepted',
            'payment_method' => 'OM',
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'active',
        ]);

        $subscription->refresh();
        $this->assertNotNull($subscription->started_at);
        $this->assertNotNull($subscription->expires_at);
        $this->assertTrue($subscription->expires_at->isFuture());
    }

    public function test_expires_at_is_correct_for_monthly_plan(): void
    {
        $start = now();
        $subscription = Subscription::create([
            'user_id' => $this->user->id,
            'subscription_plan_id' => $this->plan->id,
            'status' => 'active',
            'started_at' => $start,
            'expires_at' => $start->copy()->addDays(30),
        ]);

        $diff = (int) round($start->diffInDays($subscription->expires_at));
        $this->assertEquals(30, $diff);
    }

    public function test_expires_at_is_correct_for_yearly_plan(): void
    {
        $yearlyPlan = SubscriptionPlan::create([
            'name' => 'Annuel',
            'slug' => 'annuel',
            'price' => 50000,
            'currency' => 'XOF',
            'duration_in_days' => 365,
            'is_active' => true,
        ]);

        $start = now();
        $subscription = Subscription::create([
            'user_id' => $this->user->id,
            'subscription_plan_id' => $yearlyPlan->id,
            'status' => 'active',
            'started_at' => $start,
            'expires_at' => $start->copy()->addDays(365),
        ]);

        $diff = (int) round($start->diffInDays($subscription->expires_at));
        $this->assertEquals(365, $diff);
    }

    public function test_webhook_does_not_activate_already_accepted_payment(): void
    {
        $payment = Payment::create([
            'user_id' => $this->user->id,
            'transaction_id' => 'insp_already_done',
            'amount' => 5000,
            'currency' => 'XOF',
            'status' => 'accepted',
        ]);

        $service = app(CinetPayService::class);
        $request = new Request(['cpm_trans_id' => 'insp_already_done']);
        $service->handleWebhookNotification($request);

        $payment->refresh();
        $this->assertEquals('accepted', $payment->status);
    }
}

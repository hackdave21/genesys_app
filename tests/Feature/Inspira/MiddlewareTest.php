<?php

namespace Tests\Feature\Inspira;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareTest extends TestCase
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
    }

    public function test_user_without_active_subscription_is_blocked(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('inspira.dashboard'));

        $response->assertRedirect(route('inspira.tarifs'));
    }

    public function test_user_with_active_subscription_can_access_dashboard(): void
    {
        Subscription::create([
            'user_id' => $this->user->id,
            'subscription_plan_id' => $this->plan->id,
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);

        $this->actingAs($this->user);

        $response = $this->get(route('inspira.dashboard'));

        $response->assertStatus(200);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('inspira.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_with_expired_subscription_is_blocked(): void
    {
        Subscription::create([
            'user_id' => $this->user->id,
            'subscription_plan_id' => $this->plan->id,
            'status' => 'expired',
            'started_at' => now()->subDays(60),
            'expires_at' => now()->subDays(30),
        ]);

        $this->actingAs($this->user);

        $response = $this->get(route('inspira.dashboard'));

        $response->assertRedirect(route('inspira.tarifs'));
    }
}

<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    // Ajuste ces prix selon tes besoins
    private const MONTHLY_PRICE = 5000;
    private const YEARLY_PRICE = 50000;

    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Mensuel',
            'slug' => 'mensuel',
            'price' => self::MONTHLY_PRICE,
            'currency' => 'XOF',
            'duration_in_days' => 30,
            'is_active' => true,
        ]);

        SubscriptionPlan::create([
            'name' => 'Annuel',
            'slug' => 'annuel',
            'price' => self::YEARLY_PRICE,
            'currency' => 'XOF',
            'duration_in_days' => 365,
            'is_active' => true,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin\Inspira;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::latest()->get();
        return view('admin.inspira.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.inspira.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_plans',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:4',
            'duration_in_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        SubscriptionPlan::create($validated);

        return redirect()->route('admin.inspira.plans.index')
            ->with('success', 'Plan d\'abonnement créé avec succès.');
    }

    public function edit(SubscriptionPlan $plan)
    {
        return view('admin.inspira.plans.edit', compact('plan'));
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_plans,slug,' . $plan->id,
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:4',
            'duration_in_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $plan->update($validated);

        return redirect()->route('admin.inspira.plans.index')
            ->with('success', 'Plan d\'abonnement mis à jour.');
    }

    public function toggleStatus(SubscriptionPlan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);

        return redirect()->route('admin.inspira.plans.index')
            ->with('success', 'Statut du plan modifié.');
    }
}

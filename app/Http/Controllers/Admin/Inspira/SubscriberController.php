<?php

namespace App\Http\Controllers\Admin\Inspira;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with(['user', 'plan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->where('subscription_plan_id', $request->plan_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->latest()->paginate(15);
        $plans = \App\Models\SubscriptionPlan::all();

        return view('admin.inspira.subscribers.index', compact('subscriptions', 'plans'));
    }

    public function show(Subscription $subscription)
    {
        $subscription->load([
            'user',
            'plan',
            'payments',
            'user.contentProfile',
            'user.contentIdeas' => fn ($q) => $q->latest()->take(50),
        ]);

        return view('admin.inspira.subscribers.show', compact('subscription'));
    }

    public function updateStatus(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,expired,cancelled',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $data = ['status' => $validated['status']];

        if ($validated['status'] === 'active') {
            $data['started_at'] = $subscription->started_at ?? now();
            if (isset($validated['expires_at'])) {
                $data['expires_at'] = $validated['expires_at'];
            } elseif (!$subscription->expires_at) {
                $data['expires_at'] = now()->addDays($subscription->plan->duration_in_days);
            }
        }

        $subscription->update($data);

        return redirect()->route('admin.inspira.subscribers.show', $subscription)
            ->with('success', 'Abonnement mis à jour.');
    }
}

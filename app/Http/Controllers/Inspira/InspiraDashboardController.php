<?php

namespace App\Http\Controllers\Inspira;

use App\Http\Controllers\Controller;
use App\Models\ContentProfile;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class InspiraDashboardController extends Controller
{
    /**
     * Dashboard Inspira : statut abonnement, profil, historique.
     */
    public function index()
    {
        $user = auth()->user()->load([
            'contentProfile',
            'subscriptions.plan',
            'contentIdeas' => fn ($q) => $q->latest()->take(20),
        ]);

        $activeSubscription = $user->activeSubscription();
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('inspira.dashboard', compact('user', 'activeSubscription', 'plans'));
    }

    /**
     * Formulaire d'édition du profil de contenu.
     */
    public function editProfil()
    {
        $profile = auth()->user()->contentProfile ?? new ContentProfile();

        return view('inspira.profil', compact('profile'));
    }

    /**
     * Mise à jour du profil de contenu.
     */
    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'niche' => 'required|string|max:255',
            'target_audience' => 'nullable|string|max:255',
            'tone' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'frequency' => 'required|in:daily,weekly',
        ]);

        $user = auth()->user();

        if ($user->contentProfile) {
            $user->contentProfile->update($validated);
        } else {
            $user->contentProfile()->create($validated);
        }

        return redirect()->route('inspira.dashboard')
            ->with('success', 'Votre profil de contenu a été mis à jour.');
    }
}

<?php

namespace App\Http\Controllers\Inspira;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Services\CinetPayService;
use Illuminate\Http\Request;

class InspiraController extends Controller
{
    public function __construct(
        protected CinetPayService $cinetPay
    ) {}

    /**
     * Page de présentation publique d'Inspira.
     */
    public function index()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('inspira.index', compact('plans'));
    }

    /**
     * Page des tarifs avec les plans d'abonnement.
     */
    public function tarifs()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return view('inspira.tarifs', compact('plans'));
    }

    /**
     * Initie un abonnement via CinetPay.
     */
    public function subscribe(Request $request, SubscriptionPlan $plan)
    {
        if (!$plan->is_active) {
            return redirect()->route('inspira.tarifs')
                ->withErrors(['plan' => 'Ce plan n\'est plus disponible.']);
        }

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        try {
            $result = $this->cinetPay->initiatePayment(auth()->user(), $plan);
        } catch (\RuntimeException $e) {
            return redirect()->route('inspira.tarifs')
                ->withErrors(['payment' => $e->getMessage()]);
        }

        if (!empty($result['payment_url'])) {
            return redirect()->away($result['payment_url']);
        }

        return redirect()->route('inspira.tarifs')
            ->withErrors(['payment' => 'Erreur : aucune URL de paiement reçue.']);
    }
}

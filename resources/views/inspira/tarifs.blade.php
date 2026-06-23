@extends('layouts.app')

@section('title', 'Tarifs Inspira — Abonnement | GENESYS')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <span class="inline-block bg-brand-orange/10 text-brand-orange text-xs font-bold px-4 py-1.5 rounded-full mb-4">Abonnement</span>
        <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Choisissez votre formule</h1>
        <p class="text-gray-500 dark:text-[#888]">Vous pouvez changer de formule à tout moment</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 max-w-2xl mx-auto">
        @foreach($plans as $plan)
            <div class="card-hover border border-gray-200 dark:border-[#222] rounded-2xl p-8 text-center bg-white dark:bg-[#0a0a0a] @if($loop->first) md:translate-y-4 @endif">
                @if($loop->first)
                    <span class="inline-block bg-brand-green/10 text-brand-green text-xs font-bold px-3 py-1 rounded-full mb-4">Plus populaire</span>
                @endif
                <h3 class="text-xl font-bold mb-2">{{ $plan->name }}</h3>
                <p class="text-5xl font-extrabold text-brand-orange mb-1">{{ number_format($plan->price, 0, ',', ' ') }} <span class="text-sm font-medium text-gray-500 dark:text-[#888]">{{ $plan->currency }}</span></p>
                <p class="text-sm text-gray-500 dark:text-[#888] mb-6">
                    @if($plan->duration_in_days === 30)
                        Par mois
                    @else
                        Par an ({{ number_format($plan->price / 12, 0, ',', ' ') }} {{ $plan->currency }}/mois)
                    @endif
                </p>
                <ul class="text-sm text-left space-y-3 mb-8">
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-green flex-shrink-0"></i> 3 idées originales par envoi</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-green flex-shrink-0"></i> Contenu personnalisé IA</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-green flex-shrink-0"></i> Envoi quotidien ou hebdomadaire</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-green flex-shrink-0"></i> Tableau de bord dédié</li>
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-green flex-shrink-0"></i> Paiement sécurisé CinetPay</li>
                </ul>
                <form method="POST" action="{{ route('inspira.subscribe', $plan) }}">
                    @csrf
                    <button type="submit" class="w-full bg-brand-orange text-white font-bold py-3 rounded-lg hover:bg-orange-600 transition-colors text-sm">
                        Choisir ce plan
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <p class="text-center text-xs text-gray-400 dark:text-[#555] mt-12">
        Paiement sécurisé via <strong>CinetPay</strong> (Mobile Money, Carte bancaire).<br>
        Vous recevez vos idées par email. Pas de prélèvement automatique.
    </p>
</div>
@endsection

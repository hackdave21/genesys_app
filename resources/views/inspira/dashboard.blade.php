@extends('layouts.app')

@section('title', 'Dashboard Inspira | GENESYS')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold">Tableau de bord</h1>
            <p class="text-sm text-gray-500 dark:text-[#888]">Gérez votre abonnement Inspira</p>
        </div>
        <a href="{{ route('inspira.profile') }}" class="text-sm font-semibold text-brand-orange hover:text-orange-600 transition-colors flex items-center gap-1.5">
            <i data-lucide="settings" class="w-4 h-4"></i> Mon profil
        </a>
    </div>

    @if($activeSubscription)
        <div class="bg-brand-green/10 border border-brand-green/30 rounded-2xl p-6 mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 bg-brand-green rounded-full inline-block"></span>
                    <span class="text-xs font-bold text-brand-green uppercase tracking-wide">Actif</span>
                </div>
                <p class="text-sm text-gray-700 dark:text-[#ccc]">
                    Abonnement <strong>{{ $activeSubscription->plan->name }}</strong> —
                    expire le <strong>{{ $activeSubscription->expires_at->format('d/m/Y') }}</strong>
                </p>
            </div>
            <div class="text-sm">
                @if($activeSubscription->expires_at->diffInDays(now()) <= 7)
                    <a href="{{ route('inspira.tarifs') }}" class="bg-brand-orange text-white font-bold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition-colors text-xs">
                        Renouveler mon abonnement
                    </a>
                @endif
            </div>
        </div>
    @else
        <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-6 mb-8">
            <p class="text-sm font-semibold text-red-400">Vous n'avez pas d'abonnement actif.</p>
            <p class="text-xs text-red-400/70 mt-1">Souscrivez à un plan pour commencer à recevoir vos idées de contenu personnalisées.</p>
            <a href="{{ route('inspira.tarifs') }}" class="inline-block mt-4 bg-brand-orange text-white font-bold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition-colors text-xs">
                Voir les offres
            </a>
        </div>
    @endif

    <div class="border border-gray-200 dark:border-[#222] rounded-2xl p-6 bg-white dark:bg-[#0a0a0a] mb-8">
        <h2 class="text-lg font-bold mb-4">Mon profil de contenu</h2>
        @if($user->contentProfile)
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
                <div>
                    <p class="text-gray-500 dark:text-[#555] text-xs">Niche</p>
                    <p class="font-semibold">{{ $user->contentProfile->niche }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-[#555] text-xs">Audience</p>
                    <p class="font-semibold">{{ $user->contentProfile->target_audience ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-[#555] text-xs">Ton</p>
                    <p class="font-semibold">{{ $user->contentProfile->tone }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-[#555] text-xs">Plateforme</p>
                    <p class="font-semibold">{{ $user->contentProfile->platform }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-[#555] text-xs">Fréquence</p>
                    <p class="font-semibold">{{ $user->contentProfile->frequency === 'daily' ? 'Quotidienne' : 'Hebdomadaire (Lundi)' }}</p>
                </div>
            </div>
            <a href="{{ route('inspira.profile') }}" class="inline-block mt-4 text-sm text-brand-orange font-semibold hover:text-orange-600 transition-colors">
                Modifier mon profil →
            </a>
        @else
            <p class="text-sm text-gray-500 dark:text-[#888]">Vous n'avez pas encore configuré votre profil de contenu.</p>
            <a href="{{ route('inspira.profile') }}" class="inline-block mt-4 bg-brand-orange text-white font-bold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition-colors text-xs">
                Configurer mon profil
            </a>
        @endif
    </div>

    <div class="border border-gray-200 dark:border-[#222] rounded-2xl p-6 bg-white dark:bg-[#0a0a0a]">
        <h2 class="text-lg font-bold mb-4">Historique des idées</h2>
        @forelse($user->contentIdeas as $idea)
            <div class="border-b border-gray-100 dark:border-[#1a1a1a] py-4 last:border-0">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="prose prose-sm dark:prose-invert max-w-none text-sm text-gray-700 dark:text-[#bbb] leading-relaxed">
                            {!! nl2br(e($idea->content)) !!}
                        </div>
                        @if($idea->sent_at)
                            <p class="text-xs text-gray-400 dark:text-[#555] mt-2">Envoyé le {{ $idea->sent_at->format('d/m/Y à H:i') }}</p>
                        @endif
                    </div>
                    <span class="shrink-0 text-xs font-semibold px-2 py-1 rounded-full
                        @if($idea->status === 'sent') bg-brand-green/10 text-brand-green
                        @elseif($idea->status === 'failed') bg-red-500/10 text-red-400
                        @else bg-gray-100 dark:bg-[#1a1a1a] text-gray-500 dark:text-[#888]
                        @endif">
                        {{ $idea->status === 'sent' ? 'Envoyée' : ($idea->status === 'failed' ? 'Échec' : 'Générée') }}
                    </span>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 dark:text-[#888]">Aucune idée générée pour le moment. Les idées seront envoyées selon votre fréquence définie.</p>
        @endforelse
    </div>
</div>
@endsection

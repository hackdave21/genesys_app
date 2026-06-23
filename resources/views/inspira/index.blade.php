@extends('layouts.app')

@section('title', 'Inspira — Idées de contenu IA | GENESYS')

@section('content')
<section class="relative overflow-hidden">
    <div class="absolute inset-0 hero-grid opacity-40"></div>
    <div class="relative max-w-6xl mx-auto px-6 py-24 md:py-32 text-center">
        <span class="inline-block bg-brand-orange/10 text-brand-orange text-xs font-bold px-4 py-1.5 rounded-full mb-6 tracking-wide">✨ Propulsé par Claude (Anthropic)</span>
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
            Ne manquez jamais<br>
            <span class="text-brand-orange">d'idées de contenu</span>
        </h1>
        <p class="text-gray-500 dark:text-[#888] text-lg max-w-2xl mx-auto mb-10">
            Inspira génère pour vous des idées de contenu personnalisées, adaptées à votre niche,
            votre ton et votre plate préférée. Recevez-les par email chaque jour ou chaque semaine.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('inspira.tarifs') }}" class="bg-brand-orange text-white font-bold px-8 py-3.5 rounded-lg hover:bg-orange-600 transition-colors text-sm">
                Découvrir les offres
            </a>
            @auth
                <a href="{{ route('inspira.dashboard') }}" class="border border-gray-300 dark:border-[#333] text-gray-700 dark:text-[#ccc] font-semibold px-8 py-3.5 rounded-lg hover:bg-gray-100 dark:hover:bg-[#111] transition-colors text-sm">
                    Mon tableau de bord
                </a>
            @endauth
        </div>
    </div>
</section>

<section class="border-t border-gray-200 dark:border-[#1a1a1a] py-20">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-16">Comment ça marche ?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-14 h-14 bg-brand-orange/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="user-plus" class="w-6 h-6 text-brand-orange"></i>
                </div>
                <h3 class="text-lg font-bold mb-2">1. Créez votre profil</h3>
                <p class="text-sm text-gray-500 dark:text-[#888] leading-relaxed">Indiquez votre niche, votre audience cible, le ton souhaité et votre plateforme préférée.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-brand-orange/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="sparkles" class="w-6 h-6 text-brand-orange"></i>
                </div>
                <h3 class="text-lg font-bold mb-2">2. L'IA génère vos idées</h3>
                <p class="text-sm text-gray-500 dark:text-[#888] leading-relaxed">Notre IA Claude analyse votre profil et crée 3 idées originales avec titres, descriptions et hooks.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-brand-orange/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="mail" class="w-6 h-6 text-brand-orange"></i>
                </div>
                <h3 class="text-lg font-bold mb-2">3. Recevez par email</h3>
                <p class="text-sm text-gray-500 dark:text-[#888] leading-relaxed">Les idées vous sont envoyées directement dans votre boîte mail, quotidiennement ou chaque lundi.</p>
            </div>
        </div>
    </div>
</section>

<section class="border-t border-gray-200 dark:border-[#1a1a1a] py-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Nos formules</h2>
            <p class="text-gray-500 dark:text-[#888]">Choisissez le plan qui vous convient</p>
        </div>
        <div class="grid md:grid-cols-2 gap-8 max-w-3xl mx-auto">
            @foreach($plans as $plan)
                <div class="card-hover border border-gray-200 dark:border-[#222] rounded-2xl p-8 text-center bg-white dark:bg-[#0a0a0a]">
                    <h3 class="text-xl font-bold mb-2">{{ $plan->name }}</h3>
                    <p class="text-4xl font-extrabold text-brand-orange mb-2">{{ number_format($plan->price, 0, ',', ' ') }} <span class="text-sm font-medium text-gray-500 dark:text-[#888]">{{ $plan->currency }}</span></p>
                    <p class="text-sm text-gray-500 dark:text-[#888] mb-6">Soit {{ number_format($plan->price / $plan->duration_in_days, 0, ',', ' ') }} {{ $plan->currency }}/jour</p>
                    <ul class="text-sm text-left space-y-3 mb-8">
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-green flex-shrink-0"></i> Idées personnalisées IA</li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-green flex-shrink-0"></i> Envoi par email</li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-green flex-shrink-0"></i> Profil de contenu dédié</li>
                        <li class="flex items-center gap-3"><i data-lucide="check" class="w-4 h-4 text-brand-green flex-shrink-0"></i> Accès au tableau de bord</li>
                    </ul>
                    <a href="{{ route('inspira.tarifs') }}" class="block w-full bg-brand-orange text-white font-bold py-3 rounded-lg hover:bg-orange-600 transition-colors text-sm">
                        {{ auth()->check() ? 'Choisir ce plan' : 'S\'abonner' }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

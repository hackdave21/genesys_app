@extends('layouts.app')

@section('title', 'Mon profil de contenu — Inspira | GENESYS')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
    <a href="{{ route('inspira.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-[#888] hover:text-gray-900 dark:text-white transition-colors mb-8">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour au tableau de bord
    </a>

    <h1 class="text-2xl md:text-3xl font-extrabold mb-2">Mon profil de contenu</h1>
    <p class="text-sm text-gray-500 dark:text-[#888] mb-10">Ces informations permettent à l'IA de générer des idées parfaitement adaptées à votre activité.</p>

    <form method="POST" action="{{ route('inspira.profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="niche" class="block text-sm font-semibold mb-2">Secteur / Niche *</label>
            <input type="text" id="niche" name="niche" value="{{ old('niche', $profile->niche) }}" placeholder="ex: Marketing digital, Fitness, Cuisine, Mode..."
                class="w-full bg-gray-50 dark:bg-[#111] border border-gray-200 dark:border-[#333] rounded-lg px-4 py-3 text-sm focus:border-brand-orange outline-none transition-colors" required>
            @error('niche') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="target_audience" class="block text-sm font-semibold mb-2">Audience cible</label>
            <input type="text" id="target_audience" name="target_audience" value="{{ old('target_audience', $profile->target_audience) }}" placeholder="ex: Entrepreneurs, Mamans, Étudiants, Professionnels..."
                class="w-full bg-gray-50 dark:bg-[#111] border border-gray-200 dark:border-[#333] rounded-lg px-4 py-3 text-sm focus:border-brand-orange outline-none transition-colors">
            @error('target_audience') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="tone" class="block text-sm font-semibold mb-2">Ton *</label>
            <select id="tone" name="tone" class="w-full bg-gray-50 dark:bg-[#111] border border-gray-200 dark:border-[#333] rounded-lg px-4 py-3 text-sm focus:border-brand-orange outline-none transition-colors" required>
                <option value="">Sélectionne un ton</option>
                @foreach(['professionnel', 'humoristique', 'inspirant', 'éducatif', 'motivationnel', 'décontracté', 'formel', 'provocateur'] as $tone)
                    <option value="{{ $tone }}" @selected(old('tone', $profile->tone) === $tone)>{{ ucfirst($tone) }}</option>
                @endforeach
            </select>
            @error('tone') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="platform" class="block text-sm font-semibold mb-2">Plateforme *</label>
            <select id="platform" name="platform" class="w-full bg-gray-50 dark:bg-[#111] border border-gray-200 dark:border-[#333] rounded-lg px-4 py-3 text-sm focus:border-brand-orange outline-none transition-colors" required>
                <option value="">Sélectionne une plateforme</option>
                @foreach(['Instagram', 'TikTok', 'LinkedIn', 'YouTube', 'Blog', 'Twitter / X', 'Facebook', 'Pinterest'] as $platform)
                    <option value="{{ $platform }}" @selected(old('platform', $profile->platform) === $platform)>{{ $platform }}</option>
                @endforeach
            </select>
            @error('platform') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="frequency" class="block text-sm font-semibold mb-2">Fréquence d'envoi *</label>
            <select id="frequency" name="frequency" class="w-full bg-gray-50 dark:bg-[#111] border border-gray-200 dark:border-[#333] rounded-lg px-4 py-3 text-sm focus:border-brand-orange outline-none transition-colors" required>
                <option value="daily" @selected(old('frequency', $profile->frequency) === 'daily')>Quotidienne (tous les jours à 08:00)</option>
                <option value="weekly" @selected(old('frequency', $profile->frequency) === 'weekly')>Hebdomadaire (tous les lundis)</option>
            </select>
            @error('frequency') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-brand-orange text-white font-bold py-3 rounded-lg hover:bg-orange-600 transition-colors text-sm">
            Enregistrer mon profil
        </button>
    </form>
</div>
@endsection

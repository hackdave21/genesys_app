@extends('layouts.admin')

@section('title', 'Configuration — Inspira')
@section('page-title', 'Configuration Inspira')

@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('admin.inspira.config.update') }}" class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-[#888] mb-1.5">Fréquence par défaut</label>
            <select name="default_frequency" class="w-full bg-[#111] border border-[#222] rounded-lg px-4 py-2.5 text-sm text-[#ccc] focus:border-brand-orange outline-none">
                <option value="daily" @selected($settings['default_frequency'] === 'daily')>Quotidienne</option>
                <option value="weekly" @selected($settings['default_frequency'] === 'weekly')>Hebdomadaire</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#888] mb-1.5">Jours avant rappel de renouvellement</label>
            <input type="number" name="renewal_reminder_days" value="{{ $settings['renewal_reminder_days'] }}" min="1" max="30" class="w-full bg-[#111] border border-[#222] rounded-lg px-4 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#888] mb-1.5">Modèle Claude</label>
            <select name="anthropic_model" class="w-full bg-[#111] border border-[#222] rounded-lg px-4 py-2.5 text-sm text-[#ccc] focus:border-brand-orange outline-none">
                @foreach(['claude-sonnet-4-6', 'claude-haiku-4-5', 'claude-opus-4-7'] as $model)
                    <option value="{{ $model }}" @selected($settings['anthropic_model'] === $model)>{{ $model }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#888] mb-1.5">Prompt système (optionnel — laisse vide pour utiliser le prompt par défaut)</label>
            <textarea name="system_prompt" rows="6" class="w-full bg-[#111] border border-[#222] rounded-lg px-4 py-2.5 text-sm text-white focus:border-brand-orange outline-none font-mono">{{ $settings['system_prompt'] }}</textarea>
        </div>

        <button type="submit" class="w-full bg-brand-orange text-white font-bold py-2.5 rounded-lg hover:bg-orange-600 transition-colors text-sm">
            Enregistrer la configuration
        </button>
    </form>
</div>
@endsection

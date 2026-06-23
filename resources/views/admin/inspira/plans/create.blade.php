@extends('layouts.admin')

@section('title', 'Créer un plan — Inspira')
@section('page-title', 'Créer un plan d\'abonnement')

@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('admin.inspira.plans.store') }}" class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-[#888] mb-1.5">Nom *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-[#111] border border-[#222] rounded-lg px-4 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#888] mb-1.5">Slug *</label>
            <input type="text" name="slug" value="{{ old('slug') }}" required class="w-full bg-[#111] border border-[#222] rounded-lg px-4 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-[#888] mb-1.5">Prix *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" required class="w-full bg-[#111] border border-[#222] rounded-lg px-4 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#888] mb-1.5">Devise</label>
                <input type="text" name="currency" value="{{ old('currency', 'XOF') }}" class="w-full bg-[#111] border border-[#222] rounded-lg px-4 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#888] mb-1.5">Durée (en jours) *</label>
            <input type="number" name="duration_in_days" value="{{ old('duration_in_days') }}" required min="1" class="w-full bg-[#111] border border-[#222] rounded-lg px-4 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
        </div>

        <div>
            <label class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded border-[#333] bg-[#111] text-brand-orange focus:ring-brand-orange">
                <span class="text-sm text-[#ccc]">Actif</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-brand-orange text-white font-bold py-2.5 rounded-lg hover:bg-orange-600 transition-colors text-sm">
            Créer le plan
        </button>
    </form>
</div>
@endsection

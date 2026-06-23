@extends('layouts.admin')

@section('title', 'Plans d\'abonnement — Inspira')
@section('page-title', 'Plans d\'abonnement')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.inspira.plans.create') }}" class="bg-brand-orange text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors flex items-center gap-1.5">
        <i data-lucide="plus" class="w-4 h-4"></i> Nouveau plan
    </a>
</div>

<div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-[#1f1f1f] text-[#666] text-xs uppercase tracking-wider">
                <th class="text-left px-5 py-3">Nom</th>
                <th class="text-left px-5 py-3">Slug</th>
                <th class="text-left px-5 py-3">Prix</th>
                <th class="text-left px-5 py-3">Durée</th>
                <th class="text-left px-5 py-3">Statut</th>
                <th class="text-right px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
                <tr class="border-t border-[#1a1a1a] hover:bg-[#111] transition-colors">
                    <td class="px-5 py-3 font-semibold">{{ $plan->name }}</td>
                    <td class="px-5 py-3 text-[#888]">{{ $plan->slug }}</td>
                    <td class="px-5 py-3">{{ number_format($plan->price, 0, ',', ' ') }} {{ $plan->currency }}</td>
                    <td class="px-5 py-3">{{ $plan->duration_in_days }} jours</td>
                    <td class="px-5 py-3">
                        <span class="text-xs font-bold px-2 py-1 rounded-full {{ $plan->is_active ? 'bg-brand-green/10 text-brand-green' : 'bg-red-500/10 text-red-400' }}">
                            {{ $plan->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.inspira.plans.edit', $plan) }}" class="text-xs text-[#888] hover:text-white transition-colors flex items-center gap-1">
                                <i data-lucide="edit" class="w-3.5 h-3.5"></i> Modifier
                            </a>
                            <form method="POST" action="{{ route('admin.inspira.plans.toggle-status', $plan) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-[#888] hover:text-white transition-colors flex items-center gap-1">
                                    <i data-lucide="toggle-left" class="w-3.5 h-3.5"></i>
                                    {{ $plan->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Abonnés — Inspira')
@section('page-title', 'Abonnés Inspira')

@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-4">
    <select name="status" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] focus:border-brand-orange outline-none">
        <option value="">Tous les statuts</option>
        @foreach(['pending', 'active', 'expired', 'cancelled'] as $s)
            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <select name="plan_id" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] focus:border-brand-orange outline-none">
        <option value="">Tous les plans</option>
        @foreach($plans as $plan)
            <option value="{{ $plan->id }}" @selected((int)request('plan_id') === $plan->id)>{{ $plan->name }}</option>
        @endforeach
    </select>
    <input type="text" name="search" placeholder="Rechercher un utilisateur..." value="{{ request('search') }}" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] placeholder:text-[#555] focus:border-brand-orange outline-none min-w-[200px]">
    <button type="submit" class="bg-[#1a1a1a] text-[#ccc] text-xs font-semibold px-4 py-2 rounded-lg hover:bg-[#222] transition-colors">Filtrer</button>
</form>

<div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-[#1f1f1f] text-[#666] text-xs uppercase tracking-wider">
                <th class="text-left px-5 py-3">Utilisateur</th>
                <th class="text-left px-5 py-3">Plan</th>
                <th class="text-left px-5 py-3">Statut</th>
                <th class="text-left px-5 py-3">Expire le</th>
                <th class="text-right px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptions as $sub)
                <tr class="border-t border-[#1a1a1a] hover:bg-[#111] transition-colors">
                    <td class="px-5 py-3">
                        <p class="font-semibold">{{ $sub->user->name }}</p>
                        <p class="text-[#666] text-xs">{{ $sub->user->email }}</p>
                    </td>
                    <td class="px-5 py-3">{{ $sub->plan->name }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs font-bold px-2 py-1 rounded-full
                            @if($sub->status === 'active') bg-brand-green/10 text-brand-green
                            @elseif($sub->status === 'expired') bg-red-500/10 text-red-400
                            @elseif($sub->status === 'pending') bg-yellow-500/10 text-yellow-400
                            @else bg-[#1a1a1a] text-[#666]
                            @endif">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-[#888]">{{ $sub->expires_at ? $sub->expires_at->format('d/m/Y') : '—' }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.inspira.subscribers.show', $sub) }}" class="text-xs text-brand-orange hover:text-orange-600 transition-colors">Voir détail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $subscriptions->links() }}
</div>
@endsection

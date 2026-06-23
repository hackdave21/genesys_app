@extends('layouts.admin')

@section('title', 'Idées générées — Inspira')
@section('page-title', 'Idées de contenu générées')

@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-4">
    <input type="text" name="user_id" placeholder="ID utilisateur" value="{{ request('user_id') }}" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] placeholder:text-[#555] focus:border-brand-orange outline-none w-32">
    <select name="status" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] focus:border-brand-orange outline-none">
        <option value="">Tous les statuts</option>
        @foreach(['generated', 'sent', 'failed'] as $s)
            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] focus:border-brand-orange outline-none">
    <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] focus:border-brand-orange outline-none">
    <button type="submit" class="bg-[#1a1a1a] text-[#ccc] text-xs font-semibold px-4 py-2 rounded-lg hover:bg-[#222] transition-colors">Filtrer</button>
</form>

<div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-[#1f1f1f] text-[#666] text-xs uppercase tracking-wider">
                <th class="text-left px-5 py-3">Utilisateur</th>
                <th class="text-left px-5 py-3">Contenu</th>
                <th class="text-left px-5 py-3">Statut</th>
                <th class="text-left px-5 py-3">Envoyé le</th>
                <th class="text-left px-5 py-3">Créé le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ideas as $idea)
                <tr class="border-t border-[#1a1a1a] hover:bg-[#111] transition-colors">
                    <td class="px-5 py-3">
                        <p class="font-semibold text-xs">{{ $idea->user->name }}</p>
                        <p class="text-[#666] text-[10px]">#{{ $idea->user_id }}</p>
                    </td>
                    <td class="px-5 py-3">
                        <p class="text-xs text-[#888] leading-relaxed max-w-md">{{ Str::limit(strip_tags($idea->content), 200) }}</p>
                    </td>
                    <td class="px-5 py-3">
                        <span class="text-xs font-bold px-2 py-1 rounded-full
                            @if($idea->status === 'sent') bg-brand-green/10 text-brand-green
                            @elseif($idea->status === 'failed') bg-red-500/10 text-red-400
                            @else bg-yellow-500/10 text-yellow-400 @endif">{{ ucfirst($idea->status) }}</span>
                    </td>
                    <td class="px-5 py-3 text-xs text-[#888]">{{ $idea->sent_at?->format('d/m/Y H:i') ?? '—' }}</td>
                    <td class="px-5 py-3 text-xs text-[#888]">{{ $idea->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $ideas->links() }}</div>
@endsection

@extends('layouts.admin')

@section('title', 'Détail abonné — Inspira')
@section('page-title', 'Abonné : ' . $subscription->user->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        {{-- Subscription info --}}
        <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
            <h3 class="text-sm font-bold mb-4">Abonnement</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-[#666] text-xs">Plan</span><p class="font-semibold">{{ $subscription->plan->name }}</p></div>
                <div>
                    <span class="text-[#666] text-xs">Statut</span>
                    <p><span class="text-xs font-bold px-2 py-1 rounded-full
                        @if($subscription->status === 'active') bg-brand-green/10 text-brand-green
                        @elseif($subscription->status === 'expired') bg-red-500/10 text-red-400
                        @else bg-[#1a1a1a] text-[#666] @endif">{{ ucfirst($subscription->status) }}</span></p>
                </div>
                <div><span class="text-[#666] text-xs">Début</span><p class="font-semibold">{{ $subscription->started_at ? $subscription->started_at->format('d/m/Y') : '—' }}</p></div>
                <div><span class="text-[#666] text-xs">Expiration</span><p class="font-semibold">{{ $subscription->expires_at ? $subscription->expires_at->format('d/m/Y') : '—' }}</p></div>
            </div>

            {{-- Manual status update --}}
            <form method="POST" action="{{ route('admin.inspira.subscribers.update-status', $subscription) }}" class="mt-4 pt-4 border-t border-[#1f1f1f] flex flex-wrap gap-3">
                @csrf
                <select name="status" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] focus:border-brand-orange outline-none">
                    <option value="active" @selected($subscription->status === 'active')>Activer</option>
                    <option value="expired" @selected($subscription->status === 'expired')>Expirer</option>
                    <option value="cancelled" @selected($subscription->status === 'cancelled')>Annuler</option>
                    <option value="pending" @selected($subscription->status === 'pending')>En attente</option>
                </select>
                <input type="date" name="expires_at" value="{{ $subscription->expires_at?->format('Y-m-d') }}" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] focus:border-brand-orange outline-none">
                <button type="submit" class="bg-brand-orange text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors">Appliquer</button>
            </form>
        </div>

        {{-- Payments --}}
        <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
            <h3 class="text-sm font-bold mb-4">Paiements</h3>
            @if($subscription->payments->count())
                <table class="w-full text-sm">
                    <thead><tr class="text-[#666] text-xs uppercase tracking-wider border-b border-[#1f1f1f]">
                        <th class="text-left py-2 pr-2">Transaction</th>
                        <th class="text-left py-2 pr-2">Montant</th>
                        <th class="text-left py-2 pr-2">Statut</th>
                        <th class="text-left py-2">Date</th>
                    </tr></thead>
                    <tbody>
                        @foreach($subscription->payments as $payment)
                            <tr class="border-t border-[#1a1a1a]">
                                <td class="py-2 pr-2 text-xs text-[#888]">{{ $payment->transaction_id }}</td>
                                <td class="py-2 pr-2">{{ number_format($payment->amount, 0, ',', ' ') }} {{ $payment->currency }}</td>
                                <td class="py-2 pr-2">
                                    <span class="text-xs font-bold px-2 py-1 rounded-full
                                        @if($payment->status === 'accepted') bg-brand-green/10 text-brand-green
                                        @elseif($payment->status === 'refused') bg-red-500/10 text-red-400
                                        @else bg-yellow-500/10 text-yellow-400 @endif">{{ ucfirst($payment->status) }}</span>
                                </td>
                                <td class="py-2 text-xs text-[#888]">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm text-[#666]">Aucun paiement.</p>
            @endif
        </div>

        {{-- Content profile --}}
        <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
            <h3 class="text-sm font-bold mb-4">Profil de contenu</h3>
            @if($subscription->user->contentProfile)
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-[#666] text-xs">Niche</span><p class="font-semibold">{{ $subscription->user->contentProfile->niche }}</p></div>
                    <div><span class="text-[#666] text-xs">Audience</span><p class="font-semibold">{{ $subscription->user->contentProfile->target_audience ?? '—' }}</p></div>
                    <div><span class="text-[#666] text-xs">Ton</span><p class="font-semibold">{{ $subscription->user->contentProfile->tone }}</p></div>
                    <div><span class="text-[#666] text-xs">Plateforme</span><p class="font-semibold">{{ $subscription->user->contentProfile->platform }}</p></div>
                    <div><span class="text-[#666] text-xs">Fréquence</span><p class="font-semibold">{{ $subscription->user->contentProfile->frequency }}</p></div>
                </div>
            @else
                <p class="text-sm text-[#666]">Aucun profil configuré.</p>
            @endif
        </div>
    </div>

    {{-- Content ideas sidebar --}}
    <div class="space-y-4">
        <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
            <h3 class="text-sm font-bold mb-4">Idées envoyées</h3>
            @forelse($subscription->user->contentIdeas as $idea)
                <div class="border-b border-[#1a1a1a] py-3 last:border-0">
                    <p class="text-xs text-[#888] leading-relaxed">{{ Str::limit(strip_tags($idea->content), 120) }}</p>
                    <div class="flex items-center justify-between mt-1.5">
                        <span class="text-[10px] text-[#555]">{{ $idea->sent_at?->format('d/m/Y') ?? '—' }}</span>
                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full
                            @if($idea->status === 'sent') bg-brand-green/10 text-brand-green
                            @else bg-red-500/10 text-red-400 @endif">{{ $idea->status }}</span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#666]">Aucune idée générée.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

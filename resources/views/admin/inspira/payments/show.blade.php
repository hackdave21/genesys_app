@extends('layouts.admin')

@section('title', 'Paiement — Inspira')
@section('page-title', 'Détail du paiement #' . $payment->transaction_id)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5 space-y-4">
        <h3 class="text-sm font-bold">Informations</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><span class="text-[#666] text-xs">Transaction ID</span><p class="font-mono text-xs">{{ $payment->transaction_id }}</p></div>
            <div><span class="text-[#666] text-xs">Client</span><p class="font-semibold">{{ $payment->user->name }}<br><span class="text-xs text-[#888] font-normal">{{ $payment->user->email }}</span></p></div>
            <div><span class="text-[#666] text-xs">Montant</span><p class="font-semibold">{{ number_format($payment->amount, 0, ',', ' ') }} {{ $payment->currency }}</p></div>
            <div><span class="text-[#666] text-xs">Statut</span>
                <p><span class="text-xs font-bold px-2 py-1 rounded-full
                    @if($payment->status === 'accepted') bg-brand-green/10 text-brand-green
                    @elseif($payment->status === 'refused') bg-red-500/10 text-red-400
                    @else bg-yellow-500/10 text-yellow-400 @endif">{{ ucfirst($payment->status) }}</span></p>
            </div>
            <div><span class="text-[#666] text-xs">Méthode</span><p>{{ $payment->payment_method ?? '—' }}</p></div>
            <div><span class="text-[#666] text-xs">Payé le</span><p>{{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : '—' }}</p></div>
            <div><span class="text-[#666] text-xs">CinetPay Token</span><p class="text-xs font-mono text-[#888]">{{ $payment->cinetpay_payment_token ?? '—' }}</p></div>
            @if($payment->subscription)
                <div><span class="text-[#666] text-xs">Abonnement lié</span><p>{{ $payment->subscription->plan->name }} ({{ $payment->subscription->status }})</p></div>
            @endif
        </div>
    </div>

    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
        <h3 class="text-sm font-bold mb-4">Réponse brute CinetPay (raw_response)</h3>
        @if($payment->raw_response)
            <pre class="text-[10px] text-[#888] leading-relaxed whitespace-pre-wrap bg-[#070707] rounded-lg p-4 max-h-96 overflow-y-auto">{{ json_encode($payment->raw_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        @else
            <p class="text-sm text-[#666]">Aucune réponse stockée.</p>
        @endif
    </div>
</div>
@endsection

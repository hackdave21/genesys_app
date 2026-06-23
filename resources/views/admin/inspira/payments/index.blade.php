@extends('layouts.admin')

@section('title', 'Paiements — Inspira')
@section('page-title', 'Paiements Inspira')

@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-4">
    <select name="status" class="bg-[#111] border border-[#222] rounded-lg px-3 py-2 text-xs text-[#ccc] focus:border-brand-orange outline-none">
        <option value="">Tous les statuts</option>
        @foreach(['pending', 'accepted', 'refused', 'cancelled'] as $s)
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
                <th class="text-left px-5 py-3">Transaction</th>
                <th class="text-left px-5 py-3">Client</th>
                <th class="text-left px-5 py-3">Montant</th>
                <th class="text-left px-5 py-3">Méthode</th>
                <th class="text-left px-5 py-3">Statut</th>
                <th class="text-left px-5 py-3">Date</th>
                <th class="text-right px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr class="border-t border-[#1a1a1a] hover:bg-[#111] transition-colors">
                    <td class="px-5 py-3 text-xs text-[#888] font-mono">{{ $payment->transaction_id }}</td>
                    <td class="px-5 py-3">{{ $payment->user->name }}</td>
                    <td class="px-5 py-3 font-semibold">{{ number_format($payment->amount, 0, ',', ' ') }} {{ $payment->currency }}</td>
                    <td class="px-5 py-3 text-[#888]">{{ $payment->payment_method ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs font-bold px-2 py-1 rounded-full
                            @if($payment->status === 'accepted') bg-brand-green/10 text-brand-green
                            @elseif($payment->status === 'refused') bg-red-500/10 text-red-400
                            @elseif($payment->status === 'pending') bg-yellow-500/10 text-yellow-400
                            @else bg-[#1a1a1a] text-[#666] @endif">{{ ucfirst($payment->status) }}</span>
                    </td>
                    <td class="px-5 py-3 text-xs text-[#888]">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.inspira.payments.show', $payment) }}" class="text-xs text-brand-orange hover:text-orange-600 transition-colors">Détail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $payments->links() }}</div>
@endsection

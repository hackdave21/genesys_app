@extends('layouts.admin')

@section('title', 'Inspira — Dashboard')
@section('page-title', '📊 Inspira — Statistiques')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
        <p class="text-[#666] text-xs uppercase tracking-widest font-semibold mb-1">Abonnés actifs</p>
        <p class="text-3xl font-bold">{{ $activeSubscribers }}</p>
    </div>
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
        <p class="text-[#666] text-xs uppercase tracking-widest font-semibold mb-1">Revenu total</p>
        <p class="text-3xl font-bold text-brand-green">{{ number_format($totalRevenue, 0, ',', ' ') }} XOF</p>
    </div>
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
        <p class="text-[#666] text-xs uppercase tracking-widest font-semibold mb-1">Revenu du mois</p>
        <p class="text-3xl font-bold text-brand-orange">{{ number_format($monthRevenue, 0, ',', ' ') }} XOF</p>
    </div>
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
        <p class="text-[#666] text-xs uppercase tracking-widest font-semibold mb-1">Taux de renouvellement</p>
        <p class="text-3xl font-bold">{{ $renewalRate }}%</p>
    </div>
</div>

<div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
    <p class="text-[#666] text-xs uppercase tracking-widest font-semibold mb-4">Inscriptions par mois (12 mois)</p>
    @if($monthlySignups->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-[#666] text-xs uppercase tracking-wider">
                        <th class="text-left py-2 pr-4">Mois</th>
                        <th class="text-left py-2">Nouveaux abonnés</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlySignups as $row)
                        <tr class="border-t border-[#1a1a1a]">
                            <td class="py-2 pr-4 text-[#ccc]">{{ $row->month }}</td>
                            <td class="py-2 font-semibold">{{ $row->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-sm text-[#666]">Aucune donnée pour les 12 derniers mois.</p>
    @endif
</div>
@endsection

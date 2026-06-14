@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')

{{-- KPI GRID --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5 hover:border-brand-orange/30 transition-colors">
    <div class="flex justify-between items-start mb-3">
      <div>
        <p class="text-[10px] text-[#555] uppercase tracking-wide font-bold mb-1">Devis Reçus</p>
        <p class="font-jakarta text-2xl font-bold text-white">{{ $metrics['total_quotes'] }} <span class="text-sm font-normal text-[#555]">total</span></p>
      </div>
      <div class="w-9 h-9 bg-brand-gold/10 rounded-lg flex items-center justify-center">
        <i data-lucide="clipboard-list" class="w-5 h-5 text-brand-gold"></i>
      </div>
    </div>
    <p class="text-xs text-brand-orange font-semibold flex items-center gap-1">
      <i data-lucide="circle-dot" class="w-3 h-3"></i> {{ $metrics['new_quotes'] }} nouveaux
    </p>
  </div>

  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5 hover:border-brand-orange/30 transition-colors">
    <div class="flex justify-between items-start mb-3">
      <div>
        <p class="text-[10px] text-[#555] uppercase tracking-wide font-bold mb-1">Projets en cours</p>
        <p class="font-jakarta text-2xl font-bold text-white">{{ $metrics['active_projects'] }} <span class="text-sm font-normal text-[#555]">actifs</span></p>
      </div>
      <div class="w-9 h-9 bg-purple-500/10 rounded-lg flex items-center justify-center">
        <i data-lucide="clapperboard" class="w-5 h-5 text-purple-400"></i>
      </div>
    </div>
    <p class="text-xs text-purple-400 font-semibold flex items-center gap-1">
      <i data-lucide="trending-up" class="w-3 h-3"></i> En production
    </p>
  </div>

  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5 hover:border-brand-orange/30 transition-colors">
    <div class="flex justify-between items-start mb-3">
      <div>
        <p class="text-[10px] text-[#555] uppercase tracking-wide font-bold mb-1">Clients Inscrits</p>
        <p class="font-jakarta text-2xl font-bold text-white">{{ $metrics['total_clients'] }} <span class="text-sm font-normal text-[#555]">comptes</span></p>
      </div>
      <div class="w-9 h-9 bg-brand-green/10 rounded-lg flex items-center justify-center">
        <i data-lucide="users" class="w-5 h-5 text-brand-green"></i>
      </div>
    </div>
    <p class="text-xs text-brand-green font-semibold flex items-center gap-1">
      <i data-lucide="user-check" class="w-3 h-3"></i> Membres actifs
    </p>
  </div>

  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5 hover:border-brand-orange/30 transition-colors">
    <div class="flex justify-between items-start mb-3">
      <div>
        <p class="text-[10px] text-[#555] uppercase tracking-wide font-bold mb-1">Pipeline</p>
        <p class="font-jakarta text-2xl font-bold text-white">{{ $projectsByStep['Scripting'] + $projectsByStep['Tournage'] + $projectsByStep['Montage'] }}</p>
      </div>
      <div class="w-9 h-9 bg-brand-orange/10 rounded-lg flex items-center justify-center">
        <i data-lucide="git-branch" class="w-5 h-5 text-brand-orange"></i>
      </div>
    </div>
    <p class="text-xs text-brand-gold font-semibold flex items-center gap-1">
      <i data-lucide="layers" class="w-3 h-3"></i> {{ $projectsByStep['Terminé'] }} terminés
    </p>
  </div>

</div>

{{-- KANBAN OVERVIEW + RECENT QUOTES --}}
<div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-5 mb-5">

  {{-- Kanban Steps --}}
  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
    <div class="flex justify-between items-center mb-5">
      <h2 class="font-jakarta text-base font-bold">Pipeline de production</h2>
      <a href="{{ route('admin.projects.index') }}" class="text-xs text-brand-orange hover:underline">Voir le Kanban →</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
      @php
        $steps = [
          'Scripting' => ['color' => 'blue', 'icon' => 'pen-line'],
          'Tournage'  => ['color' => 'purple', 'icon' => 'video'],
          'Montage'   => ['color' => 'orange', 'icon' => 'scissors'],
          'Terminé'   => ['color' => 'green', 'icon' => 'check-circle'],
        ];
        $colors = [
          'blue'   => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
          'purple' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
          'orange' => 'bg-brand-orange/10 text-brand-orange border-brand-orange/20',
          'green'  => 'bg-brand-green/10 text-brand-green border-brand-green/20',
        ];
      @endphp
      @foreach($steps as $step => $cfg)
        <div class="border {{ $colors[$cfg['color']] }} rounded-xl p-4 text-center">
          <i data-lucide="{{ $cfg['icon'] }}" class="w-5 h-5 mx-auto mb-2"></i>
          <p class="text-2xl font-bold mb-1">{{ $projectsByStep[$step] }}</p>
          <p class="text-[10px] font-semibold uppercase tracking-wide opacity-70">{{ $step }}</p>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Recent activity --}}
  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
    <div class="flex justify-between items-center mb-5">
      <h2 class="font-jakarta text-base font-bold">Activité récente</h2>
      <a href="{{ route('admin.devis.index') }}" class="text-xs text-brand-orange hover:underline">Tout voir</a>
    </div>
    <div class="flex flex-col gap-4">
      @forelse($recentQuotes as $quote)
        <div class="flex gap-3 text-xs">
          <i data-lucide="clipboard-list" class="w-4 h-4 text-brand-orange flex-shrink-0 mt-0.5"></i>
          <div>
            <p class="text-[#999]">Devis de <span class="text-white font-medium">{{ $quote->client_name }}</span></p>
            <p class="text-[#444] mt-0.5">{{ $quote->project_type }} &middot;
              <span class="
                @if($quote->status === 'Nouveau') text-brand-orange
                @elseif($quote->status === 'Accepté') text-brand-green
                @elseif($quote->status === 'Refusé') text-red-400
                @else text-brand-gold
                @endif
              ">{{ $quote->status }}</span>
            </p>
          </div>
        </div>
      @empty
        <p class="text-xs text-[#555] text-center py-4">Aucune demande de devis pour l'instant.</p>
      @endforelse
    </div>
  </div>
</div>

{{-- RECENT QUOTES TABLE --}}
<div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-4 md:p-5">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-5">
    <h2 class="font-jakarta text-base font-bold">Dernières demandes de devis</h2>
    <a href="{{ route('admin.devis.index') }}" class="bg-[#1a1a1a] border border-[#2a2a2a] text-[#888] hover:text-white px-3 py-2 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
      Voir tous les devis →
    </a>
  </div>

  <div class="overflow-x-auto -mx-4 md:-mx-5 px-4 md:px-5">
    <table class="w-full min-w-[600px] border-collapse">
      <thead>
        <tr class="border-b border-[#1a1a1a]">
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Client</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Type projet</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Budget</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Statut</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Date</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold"></th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentQuotes as $quote)
          <tr class="border-b border-[#111] hover:bg-[#111]/50 transition-colors">
            <td class="py-3 px-3 text-sm font-medium text-white">{{ $quote->client_name }}</td>
            <td class="py-3 px-3 text-sm text-[#888]">{{ $quote->project_type }}</td>
            <td class="py-3 px-3 text-sm text-[#888]">{{ $quote->budget ?? 'Sur devis' }}</td>
            <td class="py-3 px-3">
              @php
                $statusClass = match($quote->status) {
                  'Nouveau'  => 'bg-brand-orange/15 text-brand-orange',
                  'Envoyé'   => 'bg-brand-gold/15 text-brand-gold',
                  'Accepté'  => 'bg-brand-green/15 text-brand-green',
                  'Refusé'   => 'bg-red-500/15 text-red-400',
                  default    => 'bg-[#222] text-[#888]',
                };
              @endphp
              <span class="{{ $statusClass }} text-[10px] font-bold px-2.5 py-1 rounded-full">{{ $quote->status }}</span>
            </td>
            <td class="py-3 px-3 text-xs text-[#555]">{{ $quote->created_at->diffForHumans() }}</td>
            <td class="py-3 px-3">
              <a href="{{ route('admin.devis.index') }}" class="text-xs text-brand-orange hover:underline">Voir →</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="py-10 text-center text-xs text-[#555]">Aucune demande de devis reçue pour l'instant.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection

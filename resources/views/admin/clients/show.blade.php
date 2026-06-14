@extends('layouts.admin')

@section('title', $client->name . ' - Profil Client')
@section('page-title', 'Profil Client')

@section('content')

<a href="{{ route('admin.clients.index') }}" class="inline-flex items-center gap-2 text-xs text-[#666] hover:text-white transition-colors mb-6">
  <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Retour à la liste des clients
</a>

<div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-5">

  {{-- Profile Card --}}
  <div class="space-y-4">
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-6 text-center">
      @if($client->avatar_url)
        <img src="{{ $client->avatar_url }}" alt="{{ $client->name }}" class="w-20 h-20 rounded-full object-cover mx-auto mb-4 border-2 border-brand-orange/30">
      @else
        <div class="w-20 h-20 bg-brand-orange/10 rounded-full flex items-center justify-center text-2xl font-bold text-brand-orange mx-auto mb-4">
          {{ strtoupper(substr($client->name, 0, 2)) }}
        </div>
      @endif
      <h2 class="text-lg font-bold text-white">{{ $client->name }}</h2>
      <p class="text-xs text-[#555] mt-1">{{ $client->email }}</p>
      @if($client->phone)
        <p class="text-xs text-[#888] mt-1">{{ $client->phone }}</p>
      @endif

      <div class="flex justify-center gap-2 mt-3">
        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
          {{ $client->status === 'active' ? 'bg-brand-green/15 text-brand-green' : 'bg-red-500/15 text-red-400' }}">
          {{ $client->status === 'active' ? 'Actif' : 'Suspendu' }}
        </span>
        @if($client->google_id)
          <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-blue-500/15 text-blue-400">
            Via Google
          </span>
        @endif
      </div>
    </div>

    {{-- Stats --}}
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
      <h3 class="text-xs text-[#555] uppercase tracking-wide font-bold mb-4">Statistiques</h3>
      <div class="space-y-3">
        <div class="flex justify-between items-center">
          <span class="text-xs text-[#888] flex items-center gap-2"><i data-lucide="clipboard-list" class="w-3.5 h-3.5"></i> Devis soumis</span>
          <span class="text-sm font-bold text-white">{{ $client->quotes->count() }}</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-xs text-[#888] flex items-center gap-2"><i data-lucide="clapperboard" class="w-3.5 h-3.5"></i> Projets</span>
          <span class="text-sm font-bold text-white">{{ $client->projects->count() }}</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-xs text-[#888] flex items-center gap-2"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> Inscrit le</span>
          <span class="text-xs text-[#555]">{{ $client->created_at->format('d/m/Y') }}</span>
        </div>
      </div>
    </div>

    {{-- Action --}}
    <form method="POST" action="{{ route('admin.clients.toggle-status', $client) }}">
      @csrf
      @method('PATCH')
      <button type="submit" class="w-full py-2.5 rounded-lg text-xs font-bold border transition-colors
        {{ $client->status === 'active'
          ? 'border-red-500/30 text-red-400 hover:bg-red-500/10'
          : 'border-brand-green/30 text-brand-green hover:bg-brand-green/10' }}">
        {{ $client->status === 'active' ? '⛔ Suspendre le compte' : '✅ Réactiver le compte' }}
      </button>
    </form>
  </div>

  {{-- History --}}
  <div class="space-y-5">

    {{-- Quotes --}}
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
      <h3 class="font-jakarta text-base font-bold mb-4 flex items-center gap-2">
        <i data-lucide="clipboard-list" class="w-4 h-4 text-brand-gold"></i>
        Demandes de devis ({{ $client->quotes->count() }})
      </h3>
      @forelse($client->quotes->sortByDesc('created_at') as $quote)
        <div class="flex items-start justify-between py-3 border-b border-[#111] last:border-0">
          <div>
            <p class="text-sm font-medium text-white">{{ $quote->project_type }}</p>
            <p class="text-xs text-[#555]">{{ $quote->created_at->format('d/m/Y') }} · {{ $quote->budget ?? 'Sur devis' }}</p>
          </div>
          @php
            $sc = match($quote->status) {
              'Nouveau'  => 'bg-brand-orange/15 text-brand-orange',
              'Envoyé'   => 'bg-brand-gold/15 text-brand-gold',
              'Accepté'  => 'bg-brand-green/15 text-brand-green',
              'Refusé'   => 'bg-red-500/15 text-red-400',
              default    => 'bg-[#222] text-[#888]',
            };
          @endphp
          <span class="{{ $sc }} text-[10px] font-bold px-2.5 py-1 rounded-full">{{ $quote->status }}</span>
        </div>
      @empty
        <p class="text-xs text-[#555] py-4 text-center">Aucun devis soumis.</p>
      @endforelse
    </div>

    {{-- Projects --}}
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5">
      <h3 class="font-jakarta text-base font-bold mb-4 flex items-center gap-2">
        <i data-lucide="clapperboard" class="w-4 h-4 text-purple-400"></i>
        Projets associés ({{ $client->projects->count() }})
      </h3>
      @forelse($client->projects->sortByDesc('created_at') as $project)
        <div class="flex items-start justify-between py-3 border-b border-[#111] last:border-0">
          <div>
            <p class="text-sm font-medium text-white">{{ $project->title }}</p>
            <p class="text-xs text-[#555]">Étape : {{ $project->step }} · Priorité : {{ $project->priority }}</p>
          </div>
          <div class="text-right">
            <div class="w-24 bg-[#1a1a1a] rounded-full h-1.5 mt-1">
              <div class="bg-brand-orange h-1.5 rounded-full" style="width: {{ $project->progress }}%"></div>
            </div>
            <p class="text-[10px] text-[#555] mt-1">{{ $project->progress }}%</p>
          </div>
        </div>
      @empty
        <p class="text-xs text-[#555] py-4 text-center">Aucun projet associé.</p>
      @endforelse
    </div>

  </div>
</div>

@endsection

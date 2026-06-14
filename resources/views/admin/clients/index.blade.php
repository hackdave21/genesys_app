@extends('layouts.admin')

@section('title', 'Clients & Contacts')
@section('page-title', 'Clients & Contacts')

@section('content')

{{-- Stats row --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
  @php
    $total     = $clients->total();
    $active    = \App\Models\User::where('role','client')->where('status','active')->count();
    $suspended = \App\Models\User::where('role','client')->where('status','suspended')->count();
    $google    = \App\Models\User::where('role','client')->whereNotNull('google_id')->count();
  @endphp
  @foreach([
    ['label'=>'Total clients',   'val'=>$total,     'icon'=>'users',        'color'=>'text-brand-orange'],
    ['label'=>'Actifs',          'val'=>$active,    'icon'=>'user-check',   'color'=>'text-brand-green'],
    ['label'=>'Suspendus',       'val'=>$suspended, 'icon'=>'user-x',       'color'=>'text-red-400'],
    ['label'=>'Via Google',      'val'=>$google,    'icon'=>'chrome',       'color'=>'text-brand-gold'],
  ] as $s)
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-4 flex items-center gap-3">
      <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 {{ $s['color'] }} flex-shrink-0"></i>
      <div>
        <p class="text-lg font-bold text-white">{{ $s['val'] }}</p>
        <p class="text-[10px] text-[#555] uppercase tracking-wide">{{ $s['label'] }}</p>
      </div>
    </div>
  @endforeach
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.clients.index') }}" class="flex flex-wrap gap-2 mb-5">
  <div class="relative flex items-center">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un client..."
      class="bg-[#111] border border-[#2a2a2a] rounded-lg pl-8 pr-3 py-2 text-xs text-white placeholder:text-[#555] focus:border-brand-orange outline-none w-52">
    <i data-lucide="search" class="w-3.5 h-3.5 text-[#555] absolute left-2.5"></i>
  </div>
  <select name="status" onchange="this.form.submit()"
    class="bg-[#111] border border-[#2a2a2a] text-[#888] text-xs rounded-lg px-3 py-2 focus:outline-none cursor-pointer hover:border-brand-orange/50 transition-colors">
    <option value="">Tous les statuts</option>
    <option value="active"     {{ request('status') === 'active'     ? 'selected' : '' }}>Actifs</option>
    <option value="suspended"  {{ request('status') === 'suspended'  ? 'selected' : '' }}>Suspendus</option>
  </select>
  @if(request()->hasAny(['search','status']))
    <a href="{{ route('admin.clients.index') }}" class="flex items-center gap-1 px-3 py-2 bg-[#1a1a1a] border border-[#2a2a2a] text-[#888] hover:text-white rounded-lg text-xs transition-colors">
      <i data-lucide="x" class="w-3 h-3"></i> Réinitialiser
    </a>
  @endif
  <button type="submit" class="flex items-center gap-1.5 px-3 py-2 bg-brand-orange/10 border border-brand-orange/30 text-brand-orange hover:bg-brand-orange/20 rounded-lg text-xs font-medium transition-colors">
    <i data-lucide="search" class="w-3 h-3"></i> Filtrer
  </button>
</form>

{{-- Clients Table --}}
<div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full min-w-[700px] border-collapse">
      <thead>
        <tr class="border-b border-[#1a1a1a]">
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Client</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Contact</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Devis</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Projets</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Statut</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Inscrit</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($clients as $client)
          <tr class="border-b border-[#111] hover:bg-[#111]/50 transition-colors">
            <td class="py-3 px-4">
              <div class="flex items-center gap-3">
                @if($client->avatar_url)
                  <img src="{{ $client->avatar_url }}" alt="{{ $client->name }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                @else
                  <div class="w-8 h-8 bg-brand-orange/10 rounded-full flex items-center justify-center text-xs font-bold text-brand-orange flex-shrink-0">
                    {{ strtoupper(substr($client->name, 0, 2)) }}
                  </div>
                @endif
                <div>
                  <p class="text-sm font-medium text-white">{{ $client->name }}</p>
                  @if($client->google_id)
                    <span class="text-[9px] bg-blue-500/10 text-blue-400 px-1.5 py-0.5 rounded font-semibold">G</span>
                  @endif
                </div>
              </div>
            </td>
            <td class="py-3 px-4">
              <p class="text-xs text-[#888]">{{ $client->email }}</p>
              @if($client->phone)
                <p class="text-xs text-[#555]">{{ $client->phone }}</p>
              @endif
            </td>
            <td class="py-3 px-4 text-sm text-white font-semibold">{{ $client->quotes_count }}</td>
            <td class="py-3 px-4 text-sm text-white font-semibold">{{ $client->projects_count }}</td>
            <td class="py-3 px-4">
              <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                {{ $client->status === 'active' ? 'bg-brand-green/15 text-brand-green' : 'bg-red-500/15 text-red-400' }}">
                {{ $client->status === 'active' ? 'Actif' : 'Suspendu' }}
              </span>
            </td>
            <td class="py-3 px-4 text-xs text-[#555]">{{ $client->created_at->format('d/m/Y') }}</td>
            <td class="py-3 px-4">
              <div class="flex items-center gap-2">
                <a href="{{ route('admin.clients.show', $client) }}"
                  class="text-[#666] hover:text-white transition-colors" title="Voir le profil">
                  <i data-lucide="eye" class="w-4 h-4"></i>
                </a>
                <form method="POST" action="{{ route('admin.clients.toggle-status', $client) }}">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="text-xs px-2.5 py-1 rounded-lg border transition-colors
                    {{ $client->status === 'active'
                      ? 'border-red-500/30 text-red-400 hover:bg-red-500/10'
                      : 'border-brand-green/30 text-brand-green hover:bg-brand-green/10' }}"
                    title="{{ $client->status === 'active' ? 'Suspendre' : 'Réactiver' }}">
                    {{ $client->status === 'active' ? 'Suspendre' : 'Réactiver' }}
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="py-16 text-center">
              <i data-lucide="users" class="w-10 h-10 text-[#333] mx-auto mb-3"></i>
              <p class="text-sm text-[#555]">Aucun client inscrit pour l'instant.</p>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($clients->hasPages())
    <div class="p-4 border-t border-[#1a1a1a] flex justify-center">
      {{ $clients->appends(request()->query())->links() }}
    </div>
  @endif
</div>

@endsection

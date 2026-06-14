@extends('layouts.admin')

@section('title', 'Demandes de Devis')
@section('page-title', 'Demandes de Devis')

@section('content')

{{-- Status Tabs --}}
<div class="flex flex-wrap gap-2 mb-6">
  @php
    $tabs = [
      null      => ['label' => 'Tous', 'count' => $counts['all'],     'color' => ''],
      'Nouveau' => ['label' => 'Nouveau', 'count' => $counts['Nouveau'], 'color' => 'orange'],
      'Envoyé'  => ['label' => 'Envoyé',  'count' => $counts['Envoyé'],  'color' => 'gold'],
      'Accepté' => ['label' => 'Accepté', 'count' => $counts['Accepté'], 'color' => 'green'],
      'Refusé'  => ['label' => 'Refusé',  'count' => $counts['Refusé'],  'color' => 'red'],
    ];
  @endphp
  @foreach($tabs as $key => $tab)
    <a href="{{ route('admin.devis.index', $key ? ['status' => $key] : []) }}"
      class="flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-semibold transition-all
        {{ $status === $key ? 'bg-brand-orange text-white' : 'bg-[#111] border border-[#2a2a2a] text-[#888] hover:text-white hover:border-[#444]' }}">
      {{ $tab['label'] }}
      <span class="{{ $status === $key ? 'bg-white/20' : 'bg-[#222]' }} text-[10px] px-2 py-0.5 rounded-full">{{ $tab['count'] }}</span>
    </a>
  @endforeach
</div>

{{-- Quotes Table --}}
<div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-4 md:p-5">
  <div class="overflow-x-auto -mx-4 md:-mx-5 px-4 md:px-5">
    <table class="w-full min-w-[750px] border-collapse">
      <thead>
        <tr class="border-b border-[#1a1a1a]">
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Client</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Entreprise</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Type de projet</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Budget</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Statut</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Date</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-2.5 px-3 font-bold">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($quotes as $quote)
          <tr class="border-b border-[#111] hover:bg-[#111]/50 transition-colors" id="quote-{{ $quote->id }}">
            <td class="py-3 px-3">
              <p class="text-sm font-medium text-white">{{ $quote->client_name }}</p>
              <p class="text-xs text-[#555]">{{ $quote->email }}</p>
              @if($quote->phone)
                <p class="text-xs text-[#555]">{{ $quote->phone }}</p>
              @endif
            </td>
            <td class="py-3 px-3 text-sm text-[#888]">{{ $quote->company ?? '—' }}</td>
            <td class="py-3 px-3 text-sm text-[#888]">{{ $quote->project_type }}</td>
            <td class="py-3 px-3 text-sm text-[#888]">{{ $quote->budget ?? 'Sur devis' }}</td>
            <td class="py-3 px-3">
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
            </td>
            <td class="py-3 px-3 text-xs text-[#555]">{{ $quote->created_at->format('d/m/Y') }}</td>
            <td class="py-3 px-3">
              <div class="flex items-center gap-2">
                {{-- Detail button --}}
                <button onclick="openDetail({{ $quote->id }})" class="text-[#666] hover:text-white transition-colors" title="Voir détail">
                  <i data-lucide="eye" class="w-4 h-4"></i>
                </button>
                {{-- Status Update --}}
                <form method="POST" action="{{ route('admin.devis.update-status', $quote) }}">
                  @csrf
                  @method('PATCH')
                  <select name="status" onchange="this.form.submit()" class="bg-[#111] border border-[#2a2a2a] text-[#888] text-xs rounded-lg px-2 py-1 cursor-pointer hover:border-brand-orange/50 transition-colors focus:outline-none">
                    @foreach(['Nouveau','Envoyé','Accepté','Refusé'] as $s)
                      <option value="{{ $s }}" {{ $quote->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                  </select>
                </form>
              </div>
            </td>
          </tr>
          {{-- Hidden detail panel (expand on click) --}}
          <tr id="detail-{{ $quote->id }}" class="hidden bg-[#0a0a0a]">
            <td colspan="7" class="px-6 py-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div>
                  <p class="text-[#555] uppercase font-bold tracking-wide mb-1">Description du projet</p>
                  <p class="text-[#bbb] leading-relaxed">{{ $quote->description ?? 'Aucune description fournie.' }}</p>
                </div>
                <div class="space-y-2">
                  @if($quote->deadline)
                    <div class="flex justify-between">
                      <span class="text-[#555]">Délai souhaité :</span>
                      <span class="text-white">{{ $quote->deadline }}</span>
                    </div>
                  @endif
                  @if($quote->referral_source)
                    <div class="flex justify-between">
                      <span class="text-[#555]">Comment nous a trouvé :</span>
                      <span class="text-white">{{ $quote->referral_source }}</span>
                    </div>
                  @endif
                  <div class="flex justify-between">
                    <span class="text-[#555]">Soumis le :</span>
                    <span class="text-white">{{ $quote->created_at->format('d/m/Y à H:i') }}</span>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="py-16 text-center">
              <i data-lucide="inbox" class="w-10 h-10 text-[#333] mx-auto mb-3"></i>
              <p class="text-sm text-[#555]">Aucune demande de devis trouvée.</p>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($quotes->hasPages())
    <div class="mt-5 flex justify-center">
      {{ $quotes->appends(request()->query())->links() }}
    </div>
  @endif
</div>

@endsection

@section('scripts')
<script>
  function openDetail(id) {
    const row = document.getElementById('detail-' + id);
    row.classList.toggle('hidden');
  }
</script>
@endsection

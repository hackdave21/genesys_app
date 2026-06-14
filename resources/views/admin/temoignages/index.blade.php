@extends('layouts.admin')

@section('title', 'Liste des Témoignages')
@section('page-title', 'Témoignages')

@section('extra-styles')
.star { color: #C5A572; }
.star-empty { color: #333; }
@endsection

@section('content')

{{-- Header actions --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.testimonials.create') }}"
      class="flex items-center gap-2 bg-gradient-to-r from-brand-orange to-orange-600 text-white font-bold px-4 py-2.5 rounded-lg text-sm hover:from-orange-600 hover:to-orange-700 transition-all">
      <i data-lucide="plus" class="w-4 h-4"></i> Ajouter un témoignage
    </a>
  </div>

  {{-- Filters --}}
  <form method="GET" action="{{ route('admin.testimonials.index') }}" class="flex flex-wrap gap-2">
    <div class="relative flex items-center">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
        class="bg-[#111] border border-[#2a2a2a] rounded-lg pl-8 pr-3 py-2 text-xs text-white placeholder:text-[#555] focus:border-brand-orange outline-none w-44">
      <i data-lucide="search" class="w-3.5 h-3.5 text-[#555] absolute left-2.5"></i>
    </div>
    <select name="status" onchange="this.form.submit()"
      class="bg-[#111] border border-[#2a2a2a] text-[#888] text-xs rounded-lg px-3 py-2 focus:outline-none cursor-pointer hover:border-brand-orange/50 transition-colors">
      <option value="">Tous les statuts</option>
      <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publiés</option>
      <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Brouillons</option>
    </select>
    @if(request()->hasAny(['search','status']))
      <a href="{{ route('admin.testimonials.index') }}" class="flex items-center gap-1 px-3 py-2 bg-[#1a1a1a] border border-[#2a2a2a] text-[#888] hover:text-white rounded-lg text-xs transition-colors">
        <i data-lucide="x" class="w-3 h-3"></i> Réinitialiser
      </a>
    @endif
  </form>
</div>

{{-- Cards grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
  @forelse($testimonials as $t)
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-5 flex flex-col gap-4 hover:border-brand-orange/20 transition-colors relative group">

      {{-- Status badge --}}
      <div class="absolute top-4 right-4">
        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
          {{ $t->status === 'published' ? 'bg-brand-green/15 text-brand-green' : 'bg-[#222] text-[#666]' }}">
          {{ $t->status === 'published' ? 'Publié' : 'Brouillon' }}
        </span>
      </div>

      {{-- Stars --}}
      <div class="flex gap-0.5">
        @for($i = 1; $i <= 5; $i++)
          <span class="{{ $i <= $t->rating ? 'star' : 'star-empty' }} text-base">★</span>
        @endfor
      </div>

      {{-- Content --}}
      <p class="text-sm text-[#bbb] leading-relaxed flex-1">"{{ Str::limit($t->content, 120) }}"</p>

      {{-- Author --}}
      <div class="flex items-center gap-3 pt-3 border-t border-[#1a1a1a]">
        <div class="w-9 h-9 bg-brand-orange/10 rounded-full flex items-center justify-center text-xs font-bold text-brand-orange flex-shrink-0">
          {{ strtoupper(substr($t->client_name, 0, 2)) }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-semibold text-white truncate">{{ $t->client_name }}</p>
          <p class="text-xs text-[#555] truncate">{{ $t->company_role }}</p>
        </div>
      </div>

      {{-- Actions --}}
      <div class="flex gap-2 mt-1">
        <a href="{{ route('admin.testimonials.edit', $t) }}"
          class="flex-1 flex items-center justify-center gap-1.5 bg-[#141414] border border-[#2a2a2a] text-[#888] hover:text-white text-xs font-medium py-2 rounded-lg transition-colors">
          <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Modifier
        </a>
        <button onclick="confirmDelete({{ $t->id }}, '{{ addslashes($t->client_name) }}')"
          class="flex items-center justify-center gap-1.5 bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500/20 text-xs font-medium px-3 py-2 rounded-lg transition-colors">
          <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
        </button>
      </div>
    </div>
  @empty
    <div class="col-span-full py-20 text-center">
      <i data-lucide="message-square-off" class="w-12 h-12 text-[#333] mx-auto mb-3"></i>
      <p class="text-sm text-[#555] mb-4">Aucun témoignage trouvé.</p>
      <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center gap-2 bg-brand-orange text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-orange-600 transition-colors">
        <i data-lucide="plus" class="w-4 h-4"></i> Ajouter le premier témoignage
      </a>
    </div>
  @endforelse
</div>

{{-- Pagination --}}
@if($testimonials->hasPages())
  <div class="mt-6 flex justify-center">
    {{ $testimonials->appends(request()->query())->links() }}
  </div>
@endif

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" class="fixed inset-0 bg-black/80 z-50 hidden items-center justify-center p-4">
  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-2xl p-6 w-full max-w-sm">
    <div class="w-12 h-12 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
      <i data-lucide="alert-triangle" class="w-6 h-6"></i>
    </div>
    <h3 class="text-center font-bold text-base mb-2">Supprimer le témoignage ?</h3>
    <p class="text-center text-xs text-[#555] mb-6">Cette action est irréversible. Le témoignage de <span id="delete-name" class="text-white font-semibold"></span> sera définitivement supprimé.</p>
    <div class="flex gap-2">
      <button onclick="closeDelete()" class="flex-1 border border-[#2a2a2a] text-[#888] hover:text-white text-xs font-semibold py-2.5 rounded-lg transition-colors">Annuler</button>
      <form id="delete-form" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="flex-1 bg-red-600 text-white text-xs font-bold py-2.5 px-6 rounded-lg hover:bg-red-700 transition-colors">Supprimer</button>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  function confirmDelete(id, name) {
    document.getElementById('delete-name').textContent = name;
    document.getElementById('delete-form').action = `/admin/testimonials/${id}`;
    const modal = document.getElementById('delete-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
  function closeDelete() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
@endsection

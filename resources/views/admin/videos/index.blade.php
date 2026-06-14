@extends('layouts.admin')

@section('title', 'Vidéos Portfolio')
@section('page-title', 'Vidéos Portfolio')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
  <a href="{{ route('admin.videos.create') }}"
    class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-orange to-orange-600 text-white font-bold px-4 py-2.5 rounded-lg text-sm hover:from-orange-600 hover:to-orange-700 transition-all">
    <i data-lucide="plus" class="w-4 h-4"></i> Ajouter une vidéo
  </a>

  {{-- Filters --}}
  <form method="GET" action="{{ route('admin.videos.index') }}" class="flex flex-wrap gap-2">
    <div class="relative flex items-center">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
        class="bg-[#111] border border-[#2a2a2a] rounded-lg pl-8 pr-3 py-2 text-xs text-white placeholder:text-[#555] focus:border-brand-orange outline-none w-44">
      <i data-lucide="search" class="w-3.5 h-3.5 text-[#555] absolute left-2.5"></i>
    </div>
    <select name="category" onchange="this.form.submit()"
      class="bg-[#111] border border-[#2a2a2a] text-[#888] text-xs rounded-lg px-3 py-2 focus:outline-none cursor-pointer hover:border-brand-orange/50 transition-colors">
      <option value="">Toutes les catégories</option>
      @foreach(['Publicité', 'Événement', 'Reels', 'Corporate'] as $cat)
        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
      @endforeach
    </select>
    @if(request()->hasAny(['search','category']))
      <a href="{{ route('admin.videos.index') }}" class="flex items-center gap-1 px-3 py-2 bg-[#1a1a1a] border border-[#2a2a2a] text-[#888] hover:text-white rounded-lg text-xs transition-colors">
        <i data-lucide="x" class="w-3 h-3"></i> Réinitialiser
      </a>
    @endif
  </form>
</div>

{{-- Video Cards Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
  @forelse($videos as $video)
    <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl overflow-hidden hover:border-brand-orange/20 transition-colors group">

      {{-- Thumbnail --}}
      <div class="relative aspect-video overflow-hidden bg-[#111]">
        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}"
          class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        {{-- Overlay play button --}}
        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
          <a href="{{ $video->embed_url }}" target="_blank"
            class="w-12 h-12 bg-brand-orange/90 rounded-full flex items-center justify-center">
            <i data-lucide="play" class="w-5 h-5 text-white ml-0.5"></i>
          </a>
        </div>
        {{-- Featured badge --}}
        @if($video->is_featured)
          <span class="absolute top-2 left-2 bg-brand-gold text-black text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">
            ★ Mis en avant
          </span>
        @endif
        {{-- Category --}}
        <span class="absolute top-2 right-2 bg-black/70 text-[#bbb] text-[9px] font-semibold px-2 py-0.5 rounded-full uppercase tracking-wide">
          {{ $video->category }}
        </span>
      </div>

      {{-- Info --}}
      <div class="p-4">
        <h3 class="text-sm font-semibold text-white mb-1 truncate">{{ $video->title }}</h3>
        @if($video->client)
          <p class="text-xs text-[#555] mb-3">Client : {{ $video->client }}</p>
        @endif

        {{-- Actions --}}
        <div class="flex gap-2">
          <a href="{{ route('admin.videos.edit', $video) }}"
            class="flex-1 flex items-center justify-center gap-1.5 bg-[#141414] border border-[#2a2a2a] text-[#888] hover:text-white text-xs font-medium py-2 rounded-lg transition-colors">
            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Modifier
          </a>
          <button onclick="confirmDeleteVideo({{ $video->id }}, '{{ addslashes($video->title) }}')"
            class="flex items-center justify-center bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500/20 px-3 py-2 rounded-lg transition-colors">
            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
          </button>
        </div>
      </div>
    </div>
  @empty
    <div class="col-span-full py-20 text-center">
      <i data-lucide="video-off" class="w-12 h-12 text-[#333] mx-auto mb-3"></i>
      <p class="text-sm text-[#555] mb-4">Aucune vidéo dans le portfolio.</p>
      <a href="{{ route('admin.videos.create') }}" class="inline-flex items-center gap-2 bg-brand-orange text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-orange-600 transition-colors">
        <i data-lucide="plus" class="w-4 h-4"></i> Ajouter la première vidéo
      </a>
    </div>
  @endforelse
</div>

{{-- Pagination --}}
@if($videos->hasPages())
  <div class="mt-6 flex justify-center">
    {{ $videos->appends(request()->query())->links() }}
  </div>
@endif

{{-- Delete Modal --}}
<div id="delete-modal-video" class="fixed inset-0 bg-black/80 z-50 hidden items-center justify-center p-4">
  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-2xl p-6 w-full max-w-sm">
    <div class="w-12 h-12 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
      <i data-lucide="alert-triangle" class="w-6 h-6"></i>
    </div>
    <h3 class="text-center font-bold text-base mb-2">Supprimer la vidéo ?</h3>
    <p class="text-center text-xs text-[#555] mb-6">La vidéo <span id="delete-video-name" class="text-white font-semibold"></span> sera définitivement supprimée du portfolio.</p>
    <div class="flex gap-2">
      <button onclick="closeDeleteVideo()" class="flex-1 border border-[#2a2a2a] text-[#888] hover:text-white text-xs font-semibold py-2.5 rounded-lg transition-colors">Annuler</button>
      <form id="delete-video-form" method="POST">
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
  function confirmDeleteVideo(id, name) {
    document.getElementById('delete-video-name').textContent = name;
    document.getElementById('delete-video-form').action = `/admin/videos/${id}`;
    const modal = document.getElementById('delete-modal-video');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
  function closeDeleteVideo() {
    const modal = document.getElementById('delete-modal-video');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
@endsection

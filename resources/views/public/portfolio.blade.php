@extends('layouts.app')

@section('title', 'Portfolio - GENESYS House')

@section('extra-styles')
<style>
  .filter-active { background: #FF6B2B; border-color: #FF6B2B; color: #fff; }
  .filter-inactive { background: transparent; border-color: #2a2a2a; color: #666; }
  .filter-inactive:hover { border-color: #444; color: #ccc; }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <section class="py-20 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-4">Portfolio</p>
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
        <div>
          <h1 class="font-jakarta text-5xl font-bold text-gray-900 dark:text-white leading-tight mb-4">Notre <span class="text-brand-orange">travail</span> parle pour nous.</h1>
          <p class="text-lg text-gray-500 dark:text-[#666] max-w-xl">Des projets livrés qui performent. Spots, Reels, Corporate, Événements. Chaque vidéo est conçue pour convertir.</p>
        </div>
        <div class="flex gap-4 text-center">
          <div>
            <p class="font-jakarta text-3xl font-bold text-brand-orange">{{ \App\Models\Video::count() }}+</p>
            <p class="text-xs text-gray-500 dark:text-[#555]">Projets</p>
          </div>
          <div class="w-px bg-[#222]"></div>
          <div>
            <p class="font-jakarta text-3xl font-bold text-brand-orange">450K+</p>
            <p class="text-xs text-gray-500 dark:text-[#555]">Vues</p>
          </div>
          <div class="w-px bg-[#222]"></div>
          <div>
            <p class="font-jakarta text-3xl font-bold text-brand-orange">{{ \App\Models\User::where('role','client')->count() }}+</p>
            <p class="text-xs text-gray-500 dark:text-[#555]">Clients</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FILTERS + GRID -->
  <section class="py-12">
    <div class="max-w-7xl mx-auto px-6">
      <!-- FILTERS -->
      <div class="flex gap-3 mb-10 flex-wrap">
        <a href="{{ route('public.portfolio') }}" class="g-filter {{ !$category ? 'filter-active' : 'filter-inactive' }} border rounded-full px-5 py-2 text-sm font-medium transition-all">
          Tous <span class="bg-white/20 rounded-full px-1.5 py-0.5 text-xs ml-1">{{ \App\Models\Video::where('status', 'visible')->count() }}</span>
        </a>
        <a href="{{ route('public.portfolio', ['category' => 'Publicité']) }}" class="g-filter {{ $category === 'Publicité' ? 'filter-active' : 'filter-inactive' }} border rounded-full px-5 py-2 text-sm font-medium transition-all">
          Spots publicitaires
        </a>
        <a href="{{ route('public.portfolio', ['category' => 'Reels']) }}" class="g-filter {{ $category === 'Reels' ? 'filter-active' : 'filter-inactive' }} border rounded-full px-5 py-2 text-sm font-medium transition-all">
          Reels / TikTok
        </a>
        <a href="{{ route('public.portfolio', ['category' => 'Corporate']) }}" class="g-filter {{ $category === 'Corporate' ? 'filter-active' : 'filter-inactive' }} border rounded-full px-5 py-2 text-sm font-medium transition-all">
          Corporate
        </a>
        <a href="{{ route('public.portfolio', ['category' => 'Événement']) }}" class="g-filter {{ $category === 'Événement' ? 'filter-active' : 'filter-inactive' }} border rounded-full px-5 py-2 text-sm font-medium transition-all">
          Événements
        </a>
      </div>

      <!-- FEATURED -->
      @php
        $featured = \App\Models\Video::where('status', 'visible')->where('is_featured', true)->latest()->first();
      @endphp
      @if($featured && !$category)
      <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-2xl overflow-hidden mb-12 group hover:border-brand-orange/40 transition-colors">
        <div class="grid grid-cols-1 lg:grid-cols-2">
          <a href="#" onclick="event.preventDefault(); openVideoPlayer('{{ $featured->video_url }}', '{{ addslashes($featured->title) }}')" class="block bg-gradient-to-br from-orange-50 dark:from-[#1a0800] to-white dark:to-[#0d0d0d] h-72 flex items-center justify-center relative overflow-hidden">
            @if($featured->thumbnail_url)
              <img src="{{ $featured->thumbnail_url }}" alt="{{ $featured->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700">
            @endif
            <button class="w-16 h-16 bg-brand-orange/90 rounded-full flex items-center justify-center hover:scale-105 transition-transform shadow-xl shadow-orange-900/50 z-10">
              <i data-lucide="play" class="w-6 h-6 text-gray-900 dark:text-white fill-current ml-1"></i>
            </button>
            <span class="absolute top-4 left-4 bg-brand-orange/15 border border-brand-orange/30 rounded px-3 py-1 text-xs text-brand-orange font-semibold flex items-center gap-1 z-10">
              <i data-lucide="star" class="w-3 h-3 fill-current"></i> En vedette
            </span>
            <span class="absolute top-4 right-4 bg-brand-gold/15 border border-brand-gold/30 rounded px-3 py-1 text-xs text-brand-gold font-semibold z-10">{{ $featured->category }}</span>
          </a>
          <div class="p-6 sm:p-10 flex flex-col justify-center">
            <p class="text-xs text-brand-orange uppercase tracking-widest font-bold mb-3">À LA UNE</p>
            <h2 class="font-jakarta text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $featured->title }}</h2>
            <p class="text-gray-500 dark:text-[#666] leading-relaxed mb-6">{{ $featured->description ?? 'Découvrez notre dernière réalisation phare, illustrant notre savoir-faire en production vidéo.' }}</p>
            <div class="flex gap-3">
              @if($featured->client)
                <div class="inline-flex items-center gap-1.5 bg-brand-orange/10 border border-brand-orange/25 rounded-lg px-4 py-2 text-sm text-brand-orange font-semibold">
                  <i data-lucide="briefcase" class="w-4 h-4"></i> {{ $featured->client }}
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endif

      <!-- GRID -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="portfolio-grid">
        @forelse($videos as $video)
          @if($featured && $video->id === $featured->id && !$category)
            @continue
          @endif
          @php
            $colors = match($video->category) {
              'Publicité' => ['bg' => 'bg-brand-orange/15', 'border' => 'border-brand-orange/30', 'text' => 'text-brand-orange'],
              'Reels'     => ['bg' => 'bg-brand-green/15', 'border' => 'border-brand-green/30', 'text' => 'text-brand-green'],
              'Événement' => ['bg' => 'bg-purple-500/15', 'border' => 'border-purple-500/30', 'text' => 'text-purple-400'],
              'Corporate' => ['bg' => 'bg-blue-500/15', 'border' => 'border-blue-500/30', 'text' => 'text-blue-400'],
              default     => ['bg' => 'bg-gray-500/15', 'border' => 'border-gray-500/30', 'text' => 'text-gray-400'],
            };
          @endphp
          <div class="portfolio-item bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl overflow-hidden card-hover group">
            <a href="#" onclick="event.preventDefault(); openVideoPlayer('{{ $video->video_url }}', '{{ addslashes($video->title) }}')" class="block h-48 bg-[#111] flex items-center justify-center relative overflow-hidden">
              @if($video->thumbnail_url)
                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-500">
              @endif
              <button class="w-12 h-12 bg-brand-orange/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg z-10">
                <i data-lucide="play" class="w-5 h-5 text-gray-900 dark:text-white fill-current ml-0.5"></i>
              </button>
              <span class="absolute top-3 left-3 {{ $colors['bg'] }} border {{ $colors['border'] }} rounded px-2 py-1 text-[10px] {{ $colors['text'] }} font-semibold z-10">
                {{ $video->category }}
              </span>
            </a>
            <div class="p-5">
              <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1 truncate">{{ $video->title }}</h3>
              <p class="text-xs text-gray-500 dark:text-[#555] mb-3 truncate">{{ $video->client ? 'Client: ' . $video->client : '' }} · {{ $video->created_at->format('Y') }}</p>
              @if($video->description)
                <p class="text-[11px] text-gray-400 dark:text-[#666] line-clamp-2">{{ $video->description }}</p>
              @endif
            </div>
          </div>
        @empty
          <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16 text-gray-500">
            <i data-lucide="video-off" class="w-12 h-12 mx-auto mb-4 text-gray-300 dark:text-[#333]"></i>
            <p>Aucune vidéo trouvée dans cette catégorie.</p>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="bg-brand-orange py-20">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left">
      <div>
        <h2 class="font-jakarta text-4xl font-bold text-gray-900 dark:text-white mb-3">Votre projet mérite d'être dans cette liste.</h2>
        <p class="text-orange-200 text-lg">Devis gratuit et sans engagement. Réponse sous 24h.</p>
      </div>
      <div class="flex gap-4 shrink-0">
        <a href="{{ route('public.contact') }}" class="bg-white text-brand-orange font-bold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors">Demander un devis</a>
      </div>
    </div>
  </section>

@endsection

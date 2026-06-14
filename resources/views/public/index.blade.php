@extends('layouts.app')

@section('content')

  <!-- HERO -->
  <section class="hero-grid min-h-[90vh] flex items-center relative overflow-hidden border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="absolute inset-0 bg-gradient-to-b from-white dark:from-[#050505] via-transparent to-white dark:to-[#050505] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center relative z-10">
      <div>
        <h1 class="font-jakarta text-5xl xl:text-6xl font-bold leading-[1.1] text-gray-900 dark:text-white mb-6">
          Nous créons les vidéos que les gens regardent<br>jusqu'au bout<br>
          <span class="text-brand-orange">et qui font sonner votre caisse.</span>
        </h1>
        <p class="text-lg text-gray-600 dark:text-[#777] leading-relaxed mb-10 max-w-xl">
          Marketing vidéo créatif. Résultats mesurables en FCFA. La créativité internationale au service de tous.
        </p>
        <div class="flex flex-wrap gap-4">
          <a href="{{ route('public.portfolio') }}" class="bg-brand-orange text-gray-900 dark:text-white font-bold px-8 py-4 rounded-lg hover:bg-orange-600 transition-colors flex items-center gap-2">
            Voir notre travail
          </a>
          <a href="{{ route('public.contact') }}" class="bg-transparent border border-gray-300 dark:border-[#333] text-gray-900 dark:text-white font-medium px-8 py-4 rounded-lg hover:border-gray-400 dark:hover:border-[#555] transition-colors flex items-center gap-2">
            Demander un devis
          </a>
        </div>
      </div>

      <div class="flex flex-col gap-4">
        <!-- VIDEO PLAYER MOCK -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-2xl overflow-hidden relative group cursor-pointer">
          <div class="bg-gradient-to-br from-orange-50 dark:from-[#1a0800] to-white dark:to-[#0d0d0d] h-64 flex items-center justify-center relative">
            <button class="w-16 h-16 bg-brand-orange rounded-full flex items-center justify-center hover:scale-105 transition-transform shadow-2xl shadow-orange-900/50 relative z-10">
              <i data-lucide="play" class="w-6 h-6 text-gray-900 dark:text-white fill-current ml-1"></i>
            </button>
            <span class="absolute bottom-4 left-5 text-xs text-gray-500 dark:text-[#555] tracking-widest uppercase">Showreel 2026 — 2 min</span>
            <span class="absolute top-4 right-4 bg-gray-50 dark:bg-white/80 dark:bg-[#0d0d0d]/80 backdrop-blur rounded px-2 py-1 text-xs text-gray-600 dark:text-[#888]">2:14</span>
          </div>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-4 card-hover">
            <div class="font-jakarta text-3xl font-bold text-brand-orange mb-1">25+</div>
            <div class="text-xs text-gray-500 dark:text-[#666]">Projets livrés</div>
          </div>
          <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-4 card-hover">
            <div class="font-jakarta text-3xl font-bold text-brand-orange mb-1">450K+</div>
            <div class="text-xs text-gray-500 dark:text-[#666]">Vues générées</div>
          </div>
          <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-4 card-hover">
            <div class="font-jakarta text-3xl font-bold text-brand-orange mb-1">18+</div>
            <div class="text-xs text-gray-500 dark:text-[#666]">Clients satisfaits</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PORTFOLIO SECTION -->
  <section class="py-24 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-end justify-between mb-12">
        <div>
          <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-3">Portfolio</p>
          <h2 class="font-jakarta text-4xl font-bold text-gray-900 dark:text-white">Notre travail récent</h2>
        </div>
        <a href="{{ route('public.portfolio') }}" class="text-sm text-gray-500 dark:text-[#555] hover:text-brand-orange flex items-center gap-1 transition-colors">
          Voir tout <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($featuredVideos as $video)
          <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl overflow-hidden card-hover group">
            <a href="{{ $video->embed_url }}" target="_blank" class="block relative h-52 overflow-hidden bg-[#111]">
              @if($video->thumbnail_url)
                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              @endif
              <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="w-12 h-12 bg-brand-orange/90 rounded-full flex items-center justify-center shadow-lg">
                  <i data-lucide="play" class="w-5 h-5 text-gray-900 dark:text-white fill-current ml-0.5"></i>
                </button>
              </div>
              <span class="absolute top-3 left-3 bg-black/70 border border-white/20 rounded px-2 py-1 text-[10px] text-white font-semibold uppercase tracking-wide">
                {{ $video->category }}
              </span>
            </a>
            <div class="p-5">
              <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1 truncate">{{ $video->title }}</h3>
              <p class="text-xs text-gray-500 dark:text-[#555] mb-3 truncate">{{ $video->client ? 'Client: ' . $video->client : '' }} · {{ $video->created_at->format('Y') }}</p>
            </div>
          </div>
        @empty
          <p class="col-span-3 text-center text-gray-500 py-10">Les projets mis en avant apparaîtront ici.</p>
        @endforelse
      </div>
    </div>
  </section>

  <!-- SERVICES SECTION -->
  <section class="py-24 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-end justify-between mb-12">
        <div>
          <p class="text-2xl text-brand-orange tracking-widest uppercase font-bold mb-3">Nos offres</p>
          <h2 class="font-jakarta text-4xl font-bold text-gray-900 dark:text-white">Des services qui s'adaptent<br>à votre budget</h2>
        </div>
        <a href="{{ route('public.services') }}" class="text-sm text-gray-500 dark:text-[#555] hover:text-brand-orange flex items-center gap-1 transition-colors">
          Voir tous les packs <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- BRONZE -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-6 card-hover hover:border-[#CD7F32]/40 flex flex-col">
          <div class="flex items-center gap-2 mb-5">
            <span class="w-2.5 h-2.5 rounded-full bg-[#CD7F32]"></span>
            <p class="text-[10px] text-[#CD7F32] uppercase tracking-widest font-bold">Pack BRONZE</p>
          </div>
          <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-2">Starter visibilité</h3>
          <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed mb-4 flex-1">4 vidéos/mois · 12 publications · 2 plateformes · Stratégie mensuelle</p>
          <div>
            <p class="text-lg font-extrabold text-brand-orange">250 000 FCFA<span class="text-xs font-normal text-gray-400 dark:text-[#555]">/mois</span></p>
            <p class="text-[10px] text-gray-400 dark:text-[#555] mt-0.5">Engagement 3 mois min.</p>
          </div>
        </div>
        <!-- SILVER -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-brand-gold rounded-xl p-6 card-hover relative flex flex-col">
          <div class="absolute top-4 right-4 bg-brand-gold text-[#0d0d0d] text-[10px] font-bold px-2 py-1 rounded">
            <i data-lucide="star" class="w-2.5 h-2.5 fill-current inline mr-0.5"></i> Populaire
          </div>
          <div class="flex items-center gap-2 mb-5">
            <span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Pack SILVER</p>
          </div>
          <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-2">Croissance</h3>
          <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed mb-4 flex-1">8 vidéos/mois · 24 publications · CM · 4 plateformes · Reporting ROI</p>
          <div>
            <p class="text-lg font-extrabold text-brand-orange">500 000 FCFA<span class="text-xs font-normal text-gray-400 dark:text-[#555]">/mois</span></p>
            <p class="text-[10px] text-gray-400 dark:text-[#555] mt-0.5">Engagement 6 mois min.</p>
          </div>
        </div>
        <!-- GOLD -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-6 card-hover flex flex-col">
          <div class="flex items-center gap-2 mb-5">
            <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
            <p class="text-[10px] text-yellow-500 dark:text-yellow-400 uppercase tracking-widest font-bold">Pack GOLD</p>
          </div>
          <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-2">Leadership</h3>
          <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed mb-4 flex-1">16 vidéos/mois · 48 publications · 7 plateformes · YouTube SEO · Ads inclus</p>
          <div>
            <p class="text-lg font-extrabold text-brand-orange">900 000 FCFA<span class="text-xs font-normal text-gray-400 dark:text-[#555]">/mois</span></p>
            <p class="text-[10px] text-gray-400 dark:text-[#555] mt-0.5">Engagement 12 mois min.</p>
          </div>
        </div>
        <!-- PERFORMANCE -->
        <div class="bg-gradient-to-br from-orange-50 dark:from-[#1a0800] to-white dark:to-[#0d0d0d] border border-brand-orange/40 rounded-xl p-6 card-hover relative flex flex-col">
          <div class="absolute top-4 right-4 bg-brand-orange text-white text-[10px] font-bold px-2 py-1 rounded">Signature</div>
          <div class="flex items-center gap-2 mb-5">
            <span class="w-2.5 h-2.5 rounded-full bg-brand-orange"></span>
            <p class="text-[10px] text-brand-orange uppercase tracking-widest font-bold">Pack PERFORMANCE</p>
          </div>
          <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-2">Risque partagé</h3>
          <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed mb-4 flex-1">Dépôt minimal + 10% du CA généré. On partage le risque ET les fruits.</p>
          <div>
            <p class="text-lg font-extrabold text-brand-orange">150 000 FCFA<span class="text-xs font-normal text-gray-400 dark:text-[#555]"> dépôt</span></p>
            <p class="text-[10px] text-gray-400 dark:text-[#555] mt-0.5">+ 10% CA additionnel / 6 mois</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- METHODOLOGY SECTION -->
  <section class="py-24 border-b border-gray-200 dark:border-[#1a1a1a] relative overflow-hidden">
    <div class="absolute top-1/2 left-1/4 -translate-y-1/2 -translate-x-1/2 w-96 h-96 bg-brand-orange/5 dark:bg-brand-orange/[0.01] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-10 w-80 h-80 bg-brand-gold/5 dark:bg-brand-gold/[0.01] rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
      <div class="text-center max-w-2xl mx-auto mb-20">
        <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-3">Notre Processus</p>
        <h2 class="font-jakarta text-4xl font-bold text-gray-900 dark:text-white mb-4">Notre méthodologie</h2>
        <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">De la première discussion à la mesure des ventes, nous suivons une méthode rigoureuse pour garantir le succès de vos campagnes.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
        <div class="hidden lg:block absolute top-1/3 left-8 right-8 h-[1px] bg-gradient-to-r from-brand-orange/20 via-brand-gold/20 to-brand-orange/20 pointer-events-none z-0"></div>

        <!-- Step 1 -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1a1a1a] hover:border-brand-orange/30 dark:hover:border-brand-orange/30 rounded-2xl p-6 relative group transition-all duration-300 hover:-translate-y-1 z-10 flex flex-col justify-between h-full">
          <div>
            <div class="flex justify-between items-start mb-6">
              <div class="w-12 h-12 bg-brand-orange/10 rounded-xl flex items-center justify-center text-brand-orange">
                <i data-lucide="users" class="w-6 h-6"></i>
              </div>
              <span class="font-jakarta text-4xl font-black text-brand-orange/10 group-hover:text-brand-orange/20 transition-colors">01</span>
            </div>
            <h3 class="font-jakarta text-lg font-bold text-gray-900 dark:text-white mb-2">Brief créatif</h3>
            <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">On comprend votre business, vos objectifs et votre audience pour poser des bases stratégiques solides.</p>
          </div>
          <div class="mt-6 pt-4 border-t border-gray-100 dark:border-[#161616] text-[10px] uppercase font-bold tracking-wider text-brand-orange">Étape 1</div>
        </div>

        <!-- Step 2 -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1a1a1a] hover:border-brand-orange/30 dark:hover:border-brand-orange/30 rounded-2xl p-6 relative group transition-all duration-300 hover:-translate-y-1 z-10 flex flex-col justify-between h-full">
          <div>
            <div class="flex justify-between items-start mb-6">
              <div class="w-12 h-12 bg-brand-orange/10 rounded-xl flex items-center justify-center text-brand-orange">
                <i data-lucide="clapperboard" class="w-6 h-6"></i>
              </div>
              <span class="font-jakarta text-4xl font-black text-brand-orange/10 group-hover:text-brand-orange/20 transition-colors">02</span>
            </div>
            <h3 class="font-jakarta text-lg font-bold text-gray-900 dark:text-white mb-2">Concept & Script</h3>
            <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">On crée une histoire captivante et persuasive, rédigée sur-mesure pour engager et convertir vos prospects.</p>
          </div>
          <div class="mt-6 pt-4 border-t border-gray-100 dark:border-[#161616] text-[10px] uppercase font-bold tracking-wider text-brand-orange">Étape 2</div>
        </div>

        <!-- Step 3 -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1a1a1a] hover:border-brand-orange/30 dark:hover:border-brand-orange/30 rounded-2xl p-6 relative group transition-all duration-300 hover:-translate-y-1 z-10 flex flex-col justify-between h-full">
          <div>
            <div class="flex justify-between items-start mb-6">
              <div class="w-12 h-12 bg-brand-orange/10 rounded-xl flex items-center justify-center text-brand-orange">
                <i data-lucide="video" class="w-6 h-6"></i>
              </div>
              <span class="font-jakarta text-4xl font-black text-brand-orange/10 group-hover:text-brand-orange/20 transition-colors">03</span>
            </div>
            <h3 class="font-jakarta text-lg font-bold text-gray-900 dark:text-white mb-2">Production</h3>
            <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">Tournage professionnel en qualité 4K avec équipement haut de gamme, montage cinématique et étalonnage.</p>
          </div>
          <div class="mt-6 pt-4 border-t border-gray-100 dark:border-[#161616] text-[10px] uppercase font-bold tracking-wider text-brand-orange">Étape 3</div>
        </div>

        <!-- Step 4 -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1a1a1a] hover:border-brand-orange/30 dark:hover:border-brand-orange/30 rounded-2xl p-6 relative group transition-all duration-300 hover:-translate-y-1 z-10 flex flex-col justify-between h-full">
          <div>
            <div class="flex justify-between items-start mb-6">
              <div class="w-12 h-12 bg-brand-orange/10 rounded-xl flex items-center justify-center text-brand-orange">
                <i data-lucide="trending-up" class="w-6 h-6"></i>
              </div>
              <span class="font-jakarta text-4xl font-black text-brand-orange/10 group-hover:text-brand-orange/20 transition-colors">04</span>
            </div>
            <h3 class="font-jakarta text-lg font-bold text-gray-900 dark:text-white mb-2">Résultats</h3>
            <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">On mesure précisément l'impact de vos vidéos sur votre chiffre d'affaires : vues, leads, ventes — en FCFA.</p>
          </div>
          <div class="mt-6 pt-4 border-t border-gray-100 dark:border-[#161616] text-[10px] uppercase font-bold tracking-wider text-brand-orange">Étape 4</div>
        </div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS SECTION -->
  <section class="py-24 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-3">Témoignages</p>
      <h2 class="font-jakarta text-4xl font-bold text-gray-900 dark:text-white mb-12">Ce que disent nos clients</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($testimonials as $testimonial)
          <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-brand-orange/20 to-orange-500/20 rounded-2xl blur-md opacity-0 group-hover:opacity-75 transition duration-300"></div>
            <div class="relative bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-2xl p-6 h-full flex flex-col card-hover shadow-lg">
              <div class="flex items-center justify-between mb-5">
                <i data-lucide="quote" class="w-6 h-6 text-brand-orange/40"></i>
                <div class="flex gap-0.5">
                  @for($i=1; $i<=5; $i++)
                    <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $testimonial->rating ? 'text-brand-gold fill-current' : 'text-gray-300 dark:text-[#333]' }}"></i>
                  @endfor
                </div>
              </div>
              <p class="font-jakarta text-sm md:text-[14px] text-gray-600 dark:text-[#b3b3b3] leading-relaxed mb-6 italic flex-1">
                « {{ $testimonial->content }} »
              </p>
              <div class="flex items-center gap-3 border-t border-gray-200/50 dark:border-[#1f1f1f]/80 pt-4">
                <div class="w-10 h-10 bg-orange-50 dark:bg-[#1a0800] border border-brand-orange/20 rounded-full flex items-center justify-center text-sm font-extrabold text-brand-orange flex-shrink-0">
                  {{ strtoupper(substr($testimonial->client_name, 0, 2)) }}
                </div>
                <div>
                  <p class="font-jakarta text-sm font-bold text-gray-900 dark:text-white truncate max-w-[150px]">{{ $testimonial->client_name }}</p>
                  <p class="font-jakarta text-xs text-gray-500 dark:text-[#666] truncate max-w-[180px]">{{ $testimonial->company_role }}</p>
                </div>
              </div>
            </div>
          </div>
        @empty
          <p class="col-span-3 text-center text-gray-500 py-10">Aucun témoignage pour le moment.</p>
        @endforelse
      </div>
    </div>
  </section>

  <!-- CTA BAND -->
  <section class="bg-brand-orange py-20">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left">
      <div>
        <h2 class="font-jakarta text-4xl font-bold text-gray-900 dark:text-white mb-3">Prêt à créer des vidéos qui convertissent vraiment ?</h2>
        <p class="text-orange-200 text-lg">Réponse garantie sous 24h. Devis gratuit et sans engagement.</p>
      </div>
      <div class="flex flex-wrap justify-center gap-4 shrink-0">
        <a href="{{ route('public.contact') }}" class="bg-white text-brand-orange font-bold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors">Demander un devis</a>
        <a href="https://wa.me/22893791188" target="_blank" rel="noopener noreferrer" class="bg-white text-brand-orange font-bold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors flex items-center gap-2">
          <svg class="w-5 h-5 text-[#25D366]" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.458 5.706 1.459h.008c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
          </svg> WhatsApp
        </a>
      </div>
    </div>
  </section>

@endsection

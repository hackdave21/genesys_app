@extends('layouts.app')

@section('title', 'À propos - GENESYS House')

@section('content')

  <!-- HERO -->
  <section class="py-20 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
      <div>
        <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-4">À propos</p>
        <h1 class="font-jakarta text-5xl font-bold text-gray-900 dark:text-white leading-tight mb-6">Nés à Lomé.<br>Pensés pour <span class="text-brand-orange">l'Afrique.</span></h1>
        <p class="text-lg text-gray-500 dark:text-[#666] leading-relaxed mb-8">GENESYS est une agence de marketing créatif vidéo basée à Lomé, Togo. Notre mission : produire des vidéos qui convertissent vraiment, avec des standards internationaux au service du marché africain.</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
          <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5 text-center">
            <p class="font-jakarta text-3xl font-bold text-brand-orange">{{ \App\Models\Video::count() }}+</p>
            <p class="text-xs text-gray-500 dark:text-[#555] mt-1">Projets livrés</p>
          </div>
          <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5 text-center">
            <p class="font-jakarta text-3xl font-bold text-brand-orange">450K+</p>
            <p class="text-xs text-gray-500 dark:text-[#555] mt-1">Vues générées</p>
          </div>
          <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5 text-center">
            <p class="font-jakarta text-3xl font-bold text-brand-orange">{{ \App\Models\User::where('role','client')->count() }}+</p>
            <p class="text-xs text-gray-500 dark:text-[#555] mt-1">Clients satisfaits</p>
          </div>
        </div>
      </div>
      <div class="flex items-center justify-center">
        <div class="relative group">
          <!-- Ambient glow -->
          <div class="absolute -inset-1.5 bg-gradient-to-r from-brand-orange to-orange-600 rounded-2xl blur-xl opacity-20 dark:opacity-30 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
          <div class="relative bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-2xl p-8 md:p-12 flex items-center justify-center w-64 h-64 md:w-72 md:h-72 shadow-xl card-hover">
            <img src="{{ asset('genesys/frontend/assets/favicon.PNG') }}" alt="GENESYS" class="w-32 h-32 md:w-40 md:h-40 object-contain transition-transform duration-500 group-hover:scale-105">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- VALEURS -->
  <section class="py-20 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-2xl text-brand-orange tracking-widest uppercase font-extrabold mb-3">Ce qui nous anime</p>
      <h2 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-10">Valeurs fondamentales</h2>
      <div class="flex flex-wrap justify-center gap-6">
        <div class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-8 card-hover">
          <div class="w-12 h-12 bg-orange-50 dark:bg-[#1a0800] border border-brand-orange/20 rounded-xl flex items-center justify-center mb-5">
            <i data-lucide="trending-up" class="w-6 h-6 text-brand-orange"></i>
          </div>
          <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3">IMPACT</h3>
          <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">Chaque projet doit générer un résultat mesurable : leads, ventes, notoriété, engagement. Pas d'exception.</p>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-8 card-hover w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
          <div class="w-12 h-12 bg-orange-50 dark:bg-[#1a0800] border border-brand-orange/20 rounded-xl flex items-center justify-center mb-5">
            <i data-lucide="sparkles" class="w-6 h-6 text-brand-orange"></i>
          </div>
          <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3">CRÉATIVITÉ</h3>
          <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">Nous refusons le copier-coller. Chaque vidéo est pensée comme une œuvre qui raconte une histoire unique.</p>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-8 card-hover w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
          <div class="w-12 h-12 bg-orange-50 dark:bg-[#1a0800] border border-brand-orange/20 rounded-xl flex items-center justify-center mb-5">
            <i data-lucide="award" class="w-6 h-6 text-brand-orange"></i>
          </div>
          <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3">EXIGENCE</h3>
          <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">Standards techniques et artistiques de niveau international. Aucun rendu approximatif ne sort de GENESYS.</p>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-8 card-hover w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
          <div class="w-12 h-12 bg-orange-50 dark:bg-[#1a0800] border border-brand-orange/20 rounded-xl flex items-center justify-center mb-5">
            <i data-lucide="eye" class="w-6 h-6 text-brand-orange"></i>
          </div>
          <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3">TRANSPARENCE</h3>
          <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">Tarifs clairs, process expliqués, résultats partagés. Aucune zone d'ombre entre nous et nos clients.</p>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-8 card-hover w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
          <div class="w-12 h-12 bg-orange-50 dark:bg-[#1a0800] border border-brand-orange/20 rounded-xl flex items-center justify-center mb-5">
            <i data-lucide="handshake" class="w-6 h-6 text-brand-orange"></i>
          </div>
          <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3">ENGAGEMENT</h3>
          <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed">Nous nous engageons sur les résultats. Notre Pack Performance est la preuve que nous partageons le risque.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CE QUI DEFINIT GENESYS (ADN) -->
  <section class="py-24 border-b border-gray-200 dark:border-[#1a1a1a] overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex flex-col lg:flex-row gap-16 lg:gap-24">
        <!-- LEFT — Sticky Label + Title -->
        <div class="lg:w-[38%] lg:sticky lg:top-28 lg:self-start">
          <span class="inline-flex items-center gap-2 mb-6">
            <span class="block w-8 h-px bg-brand-orange"></span>
            <span class="font-jakarta text-2xl text-brand-orange tracking-widest uppercase font-bold">L'ADN GENESYS</span>
          </span>
          <h2 class="font-jakarta text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white leading-[1.1] mb-6">
            Ce qui définit<br>
            <span class="text-brand-orange">notre esprit.</span>
          </h2>
          <p class="text-base text-gray-500 dark:text-[#666] leading-relaxed max-w-sm">Cinq principes gravés dans notre culture.</p>
          <div class="hidden lg:block mt-12 w-16 h-1 bg-gradient-to-r from-brand-orange to-orange-400 rounded-full"></div>
        </div>

        <!-- RIGHT — Numbered List -->
        <div class="lg:w-[62%] flex flex-col divide-y divide-gray-100 dark:divide-[#1a1a1a]">
          <!-- 01 -->
          <div class="group py-10 flex gap-6 lg:gap-10 items-start hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors duration-300 -mx-4 px-4 rounded-2xl cursor-default">
            <span class="font-jakarta text-5xl lg:text-6xl font-extrabold text-brand-orange/20 group-hover:text-brand-orange/40 transition-colors duration-300 leading-none select-none flex-shrink-0 w-20">01</span>
            <div class="pt-1">
              <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-brand-orange transition-colors duration-300">Audace Créative</h3>
              <p class="text-sm text-gray-500 dark:text-[#777] leading-relaxed">Comme Bill Bernbach de DDB le disait : <em>« Ne pas être différent, c'est virtuellement suicidaire. »</em> Nous ne faisons jamais du travail tiède. Chaque création doit surprendre, émouvoir ou provoquer.</p>
            </div>
          </div>
          <!-- 02 -->
          <div class="group py-10 flex gap-6 lg:gap-10 items-start hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors duration-300 -mx-4 px-4 rounded-2xl cursor-default">
            <span class="font-jakarta text-5xl lg:text-6xl font-extrabold text-brand-orange/20 group-hover:text-brand-orange/40 transition-colors duration-300 leading-none select-none flex-shrink-0 w-20">02</span>
            <div class="pt-1">
              <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-brand-orange transition-colors duration-300">Résultats Obsessionnels</h3>
              <p class="text-sm text-gray-500 dark:text-[#777] leading-relaxed">Notre travail doit fonctionner. Chaque franc CFA investi par un client doit produire un retour mesurable. La créativité sans résultats n'est que du divertissement.</p>
            </div>
          </div>
          <!-- 03 -->
          <div class="group py-10 flex gap-6 lg:gap-10 items-start hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors duration-300 -mx-4 px-4 rounded-2xl cursor-default">
            <span class="font-jakarta text-5xl lg:text-6xl font-extrabold text-brand-orange/20 group-hover:text-brand-orange/40 transition-colors duration-300 leading-none select-none flex-shrink-0 w-20">03</span>
            <div class="pt-1">
              <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-brand-orange transition-colors duration-300">Enracinement Culturel</h3>
              <p class="text-sm text-gray-500 dark:text-[#777] leading-relaxed">Nous connaissons les codes culturels, les langues, les émotions de notre marché. On parle ewe, kabye, français et anglais. Nous sommes d'ici et nous en sommes fiers.</p>
            </div>
          </div>
          <!-- 04 -->
          <div class="group py-10 flex gap-6 lg:gap-10 items-start hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors duration-300 -mx-4 px-4 rounded-2xl cursor-default">
            <span class="font-jakarta text-5xl lg:text-6xl font-extrabold text-brand-orange/20 group-hover:text-brand-orange/40 transition-colors duration-300 leading-none select-none flex-shrink-0 w-20">04</span>
            <div class="pt-1">
              <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-brand-orange transition-colors duration-300">Excellence sans excuses</h3>
              <p class="text-sm text-gray-500 dark:text-[#777] leading-relaxed">Pas de compromis sur la qualité, peu importe le budget. Le client qui investit 150 000 FCFA mérite autant de soin créatif que celui qui investit 1 500 000 FCFA.</p>
            </div>
          </div>
          <!-- 05 -->
          <div class="group py-10 flex gap-6 lg:gap-10 items-start hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors duration-300 -mx-4 px-4 rounded-2xl cursor-default">
            <span class="font-jakarta text-5xl lg:text-6xl font-extrabold text-brand-orange/20 group-hover:text-brand-orange/40 transition-colors duration-300 leading-none select-none flex-shrink-0 w-20">05</span>
            <div class="pt-1">
              <h3 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-brand-orange transition-colors duration-300">Générosité stratégique</h3>
              <p class="text-sm text-gray-500 dark:text-[#777] leading-relaxed">Nous éduquons notre marché. Nous partageons nos connaissances. La générosité construit la confiance et la confiance construit les empires.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="bg-brand-orange py-20">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left">
      <div>
        <h2 class="font-jakarta text-4xl font-bold text-gray-900 dark:text-white mb-3">Rejoignez nos clients satisfaits.</h2>
        <p class="text-orange-200 text-lg">Démarrons votre projet ensemble.</p>
      </div>
      <div class="flex gap-4 shrink-0 justify-center">
        <a href="{{ route('public.portfolio') }}" class="bg-white text-brand-orange font-bold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors">Voir notre travail</a>
        <a href="{{ route('public.contact') }}" class="bg-transparent text-gray-900 dark:text-white font-semibold px-8 py-4 rounded-lg border border-gray-400 dark:border-white/50 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">Nous contacter</a>
      </div>
    </div>
  </section>

@endsection

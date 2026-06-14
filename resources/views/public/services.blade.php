@extends('layouts.app')

@section('title', 'Services & Tarifs - GENESYS House')

@section('extra-styles')
<style>
  .faq-body { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
  .faq-body.open { max-height: 200px; }
  .faq-arrow { transition: transform 0.3s ease; }
  .faq-arrow.open { transform: rotate(180deg); }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <section class="py-20 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-4">Offres & Tarifs</p>
      <h1 class="font-jakarta text-5xl font-bold text-gray-900 dark:text-white mb-5">Des tarifs clairs.<br>Zéro <span class="text-brand-orange">mauvaise surprise.</span></h1>
      <p class="text-lg text-gray-500 dark:text-[#666] max-w-2xl mx-auto">Choisissez le pack adapté à vos objectifs de croissance. Tous nos abonnements incluent production vidéo, stratégie et reporting.</p>
    </div>
  </section>

  <!-- PACKS MENSUELS -->
  <section class="py-20 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-3">Abonnements mensuels</p>
      <h2 class="font-jakarta text-3xl font-bold text-gray-900 dark:text-white mb-12">Packs de visibilité continue</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- BRONZE -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-2xl p-7 card-hover hover:border-[#CD7F32]/40 flex flex-col">
          <div class="flex items-center gap-2 mb-4">
            <span class="w-3 h-3 rounded-full bg-[#CD7F32]"></span>
            <p class="text-xs text-[#CD7F32] uppercase tracking-widest font-bold">Pack BRONZE</p>
          </div>
          <h2 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-1">Starter visibilité</h2>
          <p class="text-3xl font-extrabold text-brand-orange mt-4 mb-1">250 000 <span class="text-lg font-semibold">FCFA</span></p>
          <p class="text-xs text-gray-400 dark:text-[#555] mb-5">≈ 380 € / mois</p>
          <p class="text-xs text-gray-500 dark:text-[#666] mb-5 border-b border-gray-200 dark:border-[#1a1a1a] pb-5">PME débutantes, commerçants, professions libérales</p>
          <ul class="flex flex-col gap-2.5 mb-6 flex-1">
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>4 vidéos/mois (1 mère + 3 dérivés)</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>12 publications sociales</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Stratégie mensuelle</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Reporting simple</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>2 plateformes au choix</li>
          </ul>
          <p class="text-[10px] text-gray-400 dark:text-[#444] mb-4">Engagement : 3 mois minimum</p>
          <a href="{{ route('public.contact') }}" class="block w-full bg-gray-200 dark:bg-[#1a1a1a] border border-gray-300 dark:border-[#2a2a2a] text-gray-900 dark:text-white text-sm font-bold py-3 rounded-lg text-center hover:border-[#CD7F32] hover:text-[#CD7F32] transition-colors">Choisir ce pack</a>
        </div>

        <!-- SILVER -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-300 dark:border-[#888]/40 rounded-2xl p-7 card-hover hover:border-gray-400 flex flex-col">
          <div class="flex items-center gap-2 mb-4">
            <span class="w-3 h-3 rounded-full bg-gray-400"></span>
            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Pack SILVER</p>
          </div>
          <h2 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-1">Croissance</h2>
          <p class="text-3xl font-extrabold text-brand-orange mt-4 mb-1">500 000 <span class="text-lg font-semibold">FCFA</span></p>
          <p class="text-xs text-gray-400 dark:text-[#555] mb-5">≈ 760 € / mois</p>
          <p class="text-xs text-gray-500 dark:text-[#666] mb-5 border-b border-gray-200 dark:border-[#1a1a1a] pb-5">PME en croissance, marques émergentes, e-commerce</p>
          <ul class="flex flex-col gap-2.5 mb-6 flex-1">
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>8 vidéos/mois (2 mères + 6 dérivés)</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>24 publications sociales</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Community management</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Analyse concurrence mensuelle</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Reporting ROI détaillé</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>4 plateformes (FB, IG, TikTok, LI)</li>
          </ul>
          <p class="text-[10px] text-gray-400 dark:text-[#444] mb-4">Engagement : 6 mois minimum</p>
          <a href="{{ route('public.contact') }}" class="block w-full bg-gray-200 dark:bg-[#1a1a1a] border border-gray-300 dark:border-[#2a2a2a] text-gray-900 dark:text-white text-sm font-bold py-3 rounded-lg text-center hover:border-gray-400 hover:text-white transition-colors">Choisir ce pack</a>
        </div>

        <!-- GOLD -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-brand-gold rounded-2xl p-7 card-hover relative flex flex-col">
          <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-brand-gold text-[#0d0d0d] text-xs font-bold px-4 py-1.5 rounded-full flex items-center gap-1 whitespace-nowrap">
            <i data-lucide="star" class="w-3 h-3 fill-current"></i> Le plus complet
          </div>
          <div class="flex items-center gap-2 mb-4 mt-2">
            <span class="w-3 h-3 rounded-full bg-brand-gold"></span>
            <p class="text-xs text-brand-gold uppercase tracking-widest font-bold">Pack GOLD</p>
          </div>
          <h2 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-1">Leadership</h2>
          <p class="text-3xl font-extrabold text-brand-orange mt-4 mb-1">900 000 <span class="text-lg font-semibold">FCFA</span></p>
          <p class="text-xs text-gray-400 dark:text-[#555] mb-5">≈ 1 377 € / mois</p>
          <p class="text-xs text-gray-500 dark:text-[#666] mb-5 border-b border-gray-200 dark:border-[#1a1a1a] pb-5">Marques établies, institutions, scaleups, diaspora</p>
          <ul class="flex flex-col gap-2.5 mb-6 flex-1">
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>16 vidéos/mois (4 mères + 12 dérivés)</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>48 publications sociales</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Community management complet</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Publicités payantes (budget 100K inclus)</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Stratégie mensuelle en présentiel</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>7 plateformes + YouTube SEO</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Reporting ROI premium</li>
          </ul>
          <p class="text-[10px] text-gray-400 dark:text-[#444] mb-4">Engagement : 12 mois minimum</p>
          <a href="{{ route('public.contact') }}" class="block w-full bg-brand-orange text-gray-900 dark:text-white text-sm font-bold py-3 rounded-lg text-center hover:bg-orange-600 transition-colors">Choisir ce pack</a>
        </div>

        <!-- PERFORMANCE -->
        <div class="bg-gradient-to-br from-orange-50 dark:from-[#1a0800] to-white dark:to-[#0d0d0d] border border-brand-orange/40 rounded-2xl p-7 card-hover relative flex flex-col">
          <div class="absolute -top-4 right-4 bg-brand-orange text-white text-[10px] font-bold px-3 py-1.5 rounded-full">Signature GENESYS</div>
          <div class="flex items-center gap-2 mb-4">
            <span class="w-3 h-3 rounded-full bg-brand-orange"></span>
            <p class="text-xs text-brand-orange uppercase tracking-widest font-bold">Pack PERFORMANCE</p>
          </div>
          <h2 class="font-jakarta text-xl font-bold text-gray-900 dark:text-white mb-1">Risque partagé</h2>
          <div class="mt-4 mb-2">
            <p class="text-xl font-extrabold text-brand-orange">150 000 FCFA <span class="text-sm font-normal text-gray-500 dark:text-[#666]">dépôt initial</span></p>
            <p class="text-sm font-bold text-brand-orange mt-1">+ 10% du CA additionnel</p>
          </div>
          <p class="text-xs text-gray-400 dark:text-[#555] mb-5">pendant 6 mois via codes promo / UTM</p>
          <p class="text-xs text-gray-500 dark:text-[#666] mb-5 border-b border-brand-orange/20 pb-5">PME à budget limité avec une bonne offre produit. On partage le risque ET les fruits.</p>
          <ul class="flex flex-col gap-2.5 mb-6 flex-1">
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Mêmes livrables que le Pack SILVER</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Audit préalable obligatoire</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Contrat d'exclusivité marketing</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Accès aux analytics client</li>
          </ul>
          <a href="{{ route('public.contact') }}" class="block w-full bg-brand-orange text-white text-sm font-bold py-3 rounded-lg text-center hover:bg-orange-600 transition-colors">Demander l'audit</a>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES ONE-SHOT -->
  <section class="py-20 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-3">Hors abonnement</p>
      <h2 class="font-jakarta text-3xl font-bold text-gray-900 dark:text-white mb-10">Services one-shot</h2>
      <div class="hidden md:block overflow-hidden rounded-2xl border border-gray-200 dark:border-[#1f1f1f]">
        <table class="w-full">
          <thead>
            <tr class="bg-gray-100 dark:bg-[#111] border-b border-gray-200 dark:border-[#1f1f1f]">
              <th class="text-left px-6 py-4 text-xs text-gray-500 dark:text-[#555] font-bold uppercase tracking-widest">Service</th>
              <th class="text-left px-6 py-4 text-xs text-gray-500 dark:text-[#555] font-bold uppercase tracking-widest">Tarif</th>
              <th class="text-left px-6 py-4 text-xs text-gray-500 dark:text-[#555] font-bold uppercase tracking-widest">Délai</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-[#1a1a1a]">
            <tr class="bg-gray-50 dark:bg-[#0d0d0d] hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors group">
              <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-brand-orange transition-colors">Audit stratégique complet</td>
              <td class="px-6 py-4 text-sm font-bold text-brand-orange">150 000 FCFA</td>
              <td class="px-6 py-4 text-sm text-gray-500 dark:text-[#666]">7 jours</td>
            </tr>
            <tr class="bg-gray-50 dark:bg-[#0d0d0d] hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors group">
              <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-brand-orange transition-colors">Clip institutionnel (2-3 min)</td>
              <td class="px-6 py-4 text-sm font-bold text-brand-orange">800 000 — 1 500 000 FCFA</td>
              <td class="px-6 py-4 text-sm text-gray-500 dark:text-[#666]">14 jours</td>
            </tr>
            <tr class="bg-gray-50 dark:bg-[#0d0d0d] hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors group">
              <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-brand-orange transition-colors">Couverture événementielle (1 jour)</td>
              <td class="px-6 py-4 text-sm font-bold text-brand-orange">200 000 — 400 000 FCFA</td>
              <td class="px-6 py-4 text-sm text-gray-500 dark:text-[#666]">10 jours</td>
            </tr>
            <tr class="bg-gray-50 dark:bg-[#0d0d0d] hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors group">
              <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-brand-orange transition-colors">Pack mariage haut de gamme</td>
              <td class="px-6 py-4 text-sm font-bold text-brand-orange">600 000 — 1 200 000 FCFA</td>
              <td class="px-6 py-4 text-sm text-gray-500 dark:text-[#666]">21 jours</td>
            </tr>
            <tr class="bg-gray-50 dark:bg-[#0d0d0d] hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors group">
              <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-brand-orange transition-colors">Publicité vidéo + media buying</td>
              <td class="px-6 py-4 text-sm font-bold text-brand-orange">350 000 FCFA + budget média</td>
              <td class="px-6 py-4 text-sm text-gray-500 dark:text-[#666]">10 jours</td>
            </tr>
            <tr class="bg-gray-50 dark:bg-[#0d0d0d] hover:bg-orange-50/30 dark:hover:bg-[#1a0800]/20 transition-colors group">
              <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-brand-orange transition-colors">Formation vidéo (1 journée)</td>
              <td class="px-6 py-4 text-sm font-bold text-brand-orange">250 000 FCFA</td>
              <td class="px-6 py-4 text-sm text-gray-500 dark:text-[#666]">À la demande</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Cards mobile -->
      <div class="md:hidden flex flex-col gap-3">
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5">
          <p class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Audit stratégique complet</p>
          <p class="text-brand-orange font-bold text-sm">150 000 FCFA</p>
          <p class="text-gray-400 text-xs mt-1">Délai : 7 jours</p>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5">
          <p class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Clip institutionnel (2-3 min)</p>
          <p class="text-brand-orange font-bold text-sm">800 000 — 1 500 000 FCFA</p>
          <p class="text-gray-400 text-xs mt-1">Délai : 14 jours</p>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5">
          <p class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Couverture événementielle (1 jour)</p>
          <p class="text-brand-orange font-bold text-sm">200 000 — 400 000 FCFA</p>
          <p class="text-gray-400 text-xs mt-1">Délai : 10 jours</p>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5">
          <p class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Pack mariage haut de gamme</p>
          <p class="text-brand-orange font-bold text-sm">600 000 — 1 200 000 FCFA</p>
          <p class="text-gray-400 text-xs mt-1">Délai : 21 jours</p>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5">
          <p class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Publicité vidéo + media buying</p>
          <p class="text-brand-orange font-bold text-sm">350 000 FCFA + budget média</p>
          <p class="text-gray-400 text-xs mt-1">Délai : 10 jours</p>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5">
          <p class="font-semibold text-gray-900 dark:text-white text-sm mb-1">Formation vidéo (1 journée)</p>
          <p class="text-brand-orange font-bold text-sm">250 000 FCFA</p>
          <p class="text-gray-400 text-xs mt-1">À la demande</p>
        </div>
      </div>
    </div>
  </section>

  <!-- PACKS ÉVÉNEMENTS -->
  <section class="py-20 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-3">Événements</p>
      <h2 class="font-jakarta text-3xl font-bold text-gray-900 dark:text-white mb-12">Packs événementiels</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- SOUVENIR -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-2xl p-7 card-hover hover:border-brand-orange/30 flex flex-col">
          <p class="text-xs text-gray-500 dark:text-[#555] uppercase tracking-widest font-bold mb-2">Pack Souvenir</p>
          <p class="text-3xl font-extrabold text-brand-orange mt-3 mb-1">350 000 <span class="text-lg font-semibold">FCFA</span></p>
          <p class="text-xs text-gray-400 dark:text-[#555] mb-5">Livraison 10 jours</p>
          <p class="text-xs text-gray-500 dark:text-[#666] mb-5 border-b border-gray-200 dark:border-[#1a1a1a] pb-5">Demi-journée (4h) de captation</p>
          <ul class="flex flex-col gap-2.5 mb-6 flex-1">
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>1 vidéaste + 1 photographe</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Film résumé 3-5 min</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>100 photos retouchées</li>
          </ul>
          <a href="{{ route('public.contact') }}" class="block w-full bg-gray-200 dark:bg-[#1a1a1a] border border-gray-300 dark:border-[#2a2a2a] text-gray-900 dark:text-white text-sm font-bold py-3 rounded-lg text-center hover:border-brand-orange hover:text-brand-orange transition-colors">Réserver</a>
        </div>

        <!-- PRESTIGE -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-brand-gold rounded-2xl p-7 card-hover relative flex flex-col">
          <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-brand-gold text-[#0d0d0d] text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">Recommandé</div>
          <p class="text-xs text-brand-gold uppercase tracking-widest font-bold mb-2 mt-2">Pack Prestige</p>
          <p class="text-3xl font-extrabold text-brand-orange mt-3 mb-1">750 000 <span class="text-lg font-semibold">FCFA</span></p>
          <p class="text-xs text-gray-400 dark:text-[#555] mb-5">Livraison 14 jours</p>
          <p class="text-xs text-gray-500 dark:text-[#666] mb-5 border-b border-gray-200 dark:border-[#1a1a1a] pb-5">Journée complète (10h) de captation</p>
          <ul class="flex flex-col gap-2.5 mb-6 flex-1">
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>2 vidéastes + 1 photographe</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Film cinématique 5-8 min</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Drone inclus</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Teaser 60s réseaux sociaux</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>250 photos retouchées</li>
          </ul>
          <a href="{{ route('public.contact') }}" class="block w-full bg-brand-orange text-gray-900 dark:text-white text-sm font-bold py-3 rounded-lg text-center hover:bg-orange-600 transition-colors">Réserver</a>
        </div>

        <!-- ROYAL -->
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-2xl p-7 card-hover hover:border-brand-orange/30 flex flex-col">
          <p class="text-xs text-gray-500 dark:text-[#555] uppercase tracking-widest font-bold mb-2">Pack Royal</p>
          <p class="text-3xl font-extrabold text-brand-orange mt-3 mb-1">1 500 000 <span class="text-lg font-semibold">FCFA</span></p>
          <p class="text-xs text-gray-400 dark:text-[#555] mb-5">Livraison 21 jours</p>
          <p class="text-xs text-gray-500 dark:text-[#666] mb-5 border-b border-gray-200 dark:border-[#1a1a1a] pb-5">2 jours, équipe complète</p>
          <ul class="flex flex-col gap-2.5 mb-6 flex-1">
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>3 vidéastes + 2 photographes + 1 drone</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Film 10-15 min qualité cinéma</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>3 teasers réseaux sociaux</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>500 photos retouchées</li>
            <li class="flex items-start gap-2 text-xs text-gray-600 dark:text-[#888]"><i data-lucide="check" class="w-3.5 h-3.5 text-brand-green flex-shrink-0 mt-0.5"></i>Album digital premium</li>
          </ul>
          <a href="{{ route('public.contact') }}" class="block w-full bg-gray-200 dark:bg-[#1a1a1a] border border-gray-300 dark:border-[#2a2a2a] text-gray-900 dark:text-white text-sm font-bold py-3 rounded-lg text-center hover:border-brand-orange hover:text-brand-orange transition-colors">Réserver</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="py-20 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-4xl mx-auto px-6">
      <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-3 text-center">FAQ</p>
      <h2 class="font-jakarta text-3xl font-bold text-gray-900 dark:text-white mb-10 text-center">Foire Aux Questions</h2>
      <div class="flex flex-col gap-3">
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl overflow-hidden faq-item">
          <button class="w-full p-5 flex items-center justify-between text-left font-semibold text-sm hover:text-brand-orange transition-colors" onclick="toggleFaq(this)">
            <span>Quels sont les délais de livraison ?</span>
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 dark:text-[#555] faq-arrow flex-shrink-0"></i>
          </button>
          <div class="faq-body px-5">
            <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed pb-5">Pour un spot publicitaire classique, le délai est généralement de 7 à 10 jours ouvrés après la validation du scénario et le tournage. Les Reels / TikTok peuvent être livrés sous 48h.</p>
          </div>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl overflow-hidden faq-item">
          <button class="w-full p-5 flex items-center justify-between text-left font-semibold text-sm hover:text-brand-orange transition-colors" onclick="toggleFaq(this)">
            <span>Fournissez-vous les acteurs et figurants ?</span>
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 dark:text-[#555] faq-arrow flex-shrink-0"></i>
          </button>
          <div class="faq-body px-5">
            <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed pb-5">Oui, nous pouvons nous charger du casting de modèles, d'acteurs ou de voix off. Cette option est incluse dans le Pack Prestige, ou facturée en option dans le Pack Découverte.</p>
          </div>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl overflow-hidden faq-item">
          <button class="w-full p-5 flex items-center justify-between text-left font-semibold text-sm hover:text-brand-orange transition-colors" onclick="toggleFaq(this)">
            <span>Peut-on filmer en dehors de Lomé ?</span>
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 dark:text-[#555] faq-arrow flex-shrink-0"></i>
          </button>
          <div class="faq-body px-5">
            <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed pb-5">Absolument. Nous travaillons principalement à Lomé, mais nous nous déplaçons régulièrement à l'intérieur du Togo (Kara, Kpalimé, Atakpamé) et dans les pays voisins (Bénin, Ghana) moyennant des frais de déplacement.</p>
          </div>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl overflow-hidden faq-item">
          <button class="w-full p-5 flex items-center justify-between text-left font-semibold text-sm hover:text-brand-orange transition-colors" onclick="toggleFaq(this)">
            <span>Quelle est votre politique de révision ?</span>
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 dark:text-[#555] faq-arrow flex-shrink-0"></i>
          </button>
          <div class="faq-body px-5">
            <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed pb-5">Chaque projet inclut 2 tours de révision inclus dans le tarif. Des révisions supplémentaires peuvent être facturées selon le volume de modifications demandées.</p>
          </div>
        </div>
        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl overflow-hidden faq-item">
          <button class="w-full p-5 flex items-center justify-between text-left font-semibold text-sm hover:text-brand-orange transition-colors" onclick="toggleFaq(this)">
            <span>Travaillez-vous avec les institutions et ONG ?</span>
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 dark:text-[#555] faq-arrow flex-shrink-0"></i>
          </button>
          <div class="faq-body px-5">
            <p class="text-sm text-gray-500 dark:text-[#666] leading-relaxed pb-5">Oui. Nous produisons des vidéos institutionnelles pour les organisations internationales avec sous-titrage multilingue et versions multi-formats.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="bg-brand-orange py-20">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left">
      <div>
        <h2 class="font-jakarta text-4xl font-bold text-gray-900 dark:text-white mb-3">Une offre sur-mesure ?</h2>
        <p class="text-orange-200 text-lg">Contactez GENESYS directement, il trouvera une solution adaptée.</p>
      </div>
      <div class="flex flex-wrap justify-center gap-4 shrink-0">
        <a href="{{ route('public.contact') }}" class="bg-white text-brand-orange font-bold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors">Nous contacter</a>
        <a href="https://wa.me/22893791188" target="_blank" rel="noopener noreferrer" class="bg-white text-brand-orange font-bold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors flex items-center gap-2">
          <svg class="w-5 h-5 text-[#25D366]" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.458 5.706 1.459h.008c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
          </svg> WhatsApp
        </a>
      </div>
    </div>
  </section>

@endsection

@section('scripts')
<script>
  function toggleFaq(btn) {
    const body = btn.nextElementSibling;
    const arrow = btn.querySelector('.faq-arrow');
    const allBodies = document.querySelectorAll('.faq-body');
    const allArrows = document.querySelectorAll('.faq-arrow');
    
    if (!body.classList.contains('open')) {
      allBodies.forEach(b => b.classList.remove('open'));
      allArrows.forEach(a => a.classList.remove('open'));
      body.classList.add('open');
      arrow.classList.add('open');
    } else {
      body.classList.remove('open');
      arrow.classList.remove('open');
    }
  }
</script>
@endsection

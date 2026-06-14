@extends('layouts.app')

@section('title', 'Contact - GENESYS House')

@section('extra-styles')
<style>
  input, select, textarea { transition: border-color 0.2s ease; }
  input:focus, select:focus, textarea:focus { border-color: #FF6B2B !important; outline: none; }
  .budget-pill { transition: all 0.2s ease; }
</style>
@endsection

@section('content')

  <!-- HERO -->
  <section class="py-20 border-b border-gray-200 dark:border-[#1a1a1a]">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-xs text-brand-orange tracking-widest uppercase font-semibold mb-4">Contact</p>
      <h1 class="font-jakarta text-5xl font-bold text-gray-900 dark:text-white mb-5">Parlons de votre <span class="text-brand-orange">prochain projet.</span></h1>
      <p class="text-lg text-gray-500 dark:text-[#666] max-w-xl mb-6">Réponse garantie sous 24h. Devis gratuit et sans engagement. Basés à Lomé, on travaille partout en Afrique de l'Ouest.</p>
      <div class="flex gap-6 text-sm">
        <div class="flex items-center gap-2 text-gray-600 dark:text-[#777]"><span class="w-2 h-2 bg-brand-green rounded-full"></span> Lun–Ven : 08h–18h</div>
        <div class="flex items-center gap-2 text-gray-600 dark:text-[#777]"><span class="w-2 h-2 bg-brand-green rounded-full"></span> Samedi : 09h–14h</div>
        <div class="flex items-center gap-2 text-gray-600 dark:text-[#777]"><span class="w-2 h-2 bg-brand-orange rounded-full"></span> WhatsApp 24/7</div>
      </div>
    </div>
  </section>

  <!-- CONTACT BODY -->
  <section class="py-16">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-[1.6fr_1fr] gap-12">

      <!-- FORM -->
      <div>
        <h2 class="font-jakarta text-2xl font-bold text-gray-900 dark:text-white mb-8">Demander un devis</h2>

        @if(session('success'))
          <div class="mb-5 bg-brand-green/10 border border-brand-green/30 rounded-xl p-6 text-center">
            <i data-lucide="check-circle" class="w-10 h-10 text-brand-green mx-auto mb-3"></i>
            <p class="font-jakarta text-xl font-bold text-brand-green mb-1">Message envoyé !</p>
            <p class="text-sm text-gray-500 dark:text-[#666]">{{ session('success') }}</p>
          </div>
        @endif

        @if($errors->any())
          <div class="mb-5 bg-red-500/10 border border-red-500/30 rounded-xl p-4">
            <ul class="text-sm text-red-500 list-disc list-inside">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('public.devis.store') }}" method="POST">
          @csrf
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
            <div>
              <label class="block text-xs text-gray-500 dark:text-[#666] font-semibold mb-2 uppercase tracking-wide">Prénom & Nom *</label>
              <input type="text" name="client_name" value="{{ old('client_name', Auth::check() ? Auth::user()->name : '') }}" required placeholder="Kofi Adzoa" class="w-full bg-gray-50 dark:bg-[#0d0d0d] border border-gray-300 dark:border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:text-[#444] font-jakarta">
            </div>
            <div>
              <label class="block text-xs text-gray-500 dark:text-[#666] font-semibold mb-2 uppercase tracking-wide">Entreprise</label>
              <input type="text" name="company" value="{{ old('company') }}" placeholder="Ecobank Togo" class="w-full bg-gray-50 dark:bg-[#0d0d0d] border border-gray-300 dark:border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:text-[#444] font-jakarta">
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
            <div>
              <label class="block text-xs text-gray-500 dark:text-[#666] font-semibold mb-2 uppercase tracking-wide">Email *</label>
              <input type="email" name="email" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" required placeholder="kofi@entreprise.tg" class="w-full bg-gray-50 dark:bg-[#0d0d0d] border border-gray-300 dark:border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:text-[#444] font-jakarta">
            </div>
            <div>
              <label class="block text-xs text-gray-500 dark:text-[#666] font-semibold mb-2 uppercase tracking-wide">Téléphone / WhatsApp</label>
              <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+228 XX XX XX XX" class="w-full bg-gray-50 dark:bg-[#0d0d0d] border border-gray-300 dark:border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:text-[#444] font-jakarta">
            </div>
          </div>

          <div class="mb-5">
            <label class="block text-xs text-gray-500 dark:text-[#666] font-semibold mb-2 uppercase tracking-wide">Type de projet *</label>
            <select name="project_type" required class="w-full bg-gray-50 dark:bg-[#0d0d0d] border border-gray-300 dark:border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-gray-600 dark:text-[#888] font-jakarta cursor-pointer appearance-none">
              <option value="" disabled selected>Sélectionner un service…</option>
              <option value="Spot publicitaire" {{ old('project_type') == 'Spot publicitaire' ? 'selected' : '' }}>Spot publicitaire</option>
              <option value="Pack PME Visibilité" {{ old('project_type') == 'Pack PME Visibilité' ? 'selected' : '' }}>Pack PME Visibilité</option>
              <option value="Reels / TikTok" {{ old('project_type') == 'Reels / TikTok' ? 'selected' : '' }}>Reels / TikTok</option>
              <option value="Film de mariage / événement" {{ old('project_type') == 'Film de mariage / événement' ? 'selected' : '' }}>Film de mariage / événement</option>
              <option value="Production institutionnelle" {{ old('project_type') == 'Production institutionnelle' ? 'selected' : '' }}>Production institutionnelle</option>
              <option value="Motion Design" {{ old('project_type') == 'Motion Design' ? 'selected' : '' }}>Motion Design</option>
              <option value="Autre" {{ old('project_type') == 'Autre' ? 'selected' : '' }}>Autre</option>
            </select>
          </div>

          <div class="mb-5">
            <label class="block text-xs text-gray-500 dark:text-[#666] font-semibold mb-3 uppercase tracking-wide">Budget estimé</label>
            <input type="hidden" name="budget" id="budget-input" value="{{ old('budget', '150k – 350k FCFA') }}">
            <div class="flex flex-wrap gap-2" id="budget-options">
              <button type="button" class="budget-pill border border-gray-300 dark:border-[#2a2a2a] text-gray-500 dark:text-[#666] bg-transparent rounded-full px-4 py-2 text-xs font-medium hover:border-gray-400 dark:hover:border-[#444] hover:text-[#ccc]" onclick="selectBudget(this, '< 150 000 FCFA')">&lt; 150 000 FCFA</button>
              <button type="button" class="budget-pill border border-brand-orange text-brand-orange bg-brand-orange/10 rounded-full px-4 py-2 text-xs font-medium" onclick="selectBudget(this, '150k – 350k FCFA')">150k – 350k FCFA</button>
              <button type="button" class="budget-pill border border-gray-300 dark:border-[#2a2a2a] text-gray-500 dark:text-[#666] bg-transparent rounded-full px-4 py-2 text-xs font-medium hover:border-gray-400 dark:hover:border-[#444] hover:text-[#ccc]" onclick="selectBudget(this, '350k – 700k FCFA')">350k – 700k FCFA</button>
              <button type="button" class="budget-pill border border-gray-300 dark:border-[#2a2a2a] text-gray-500 dark:text-[#666] bg-transparent rounded-full px-4 py-2 text-xs font-medium hover:border-gray-400 dark:hover:border-[#444] hover:text-[#ccc]" onclick="selectBudget(this, '> 700 000 FCFA')">&gt; 700 000 FCFA</button>
              <button type="button" class="budget-pill border border-gray-300 dark:border-[#2a2a2a] text-gray-500 dark:text-[#666] bg-transparent rounded-full px-4 py-2 text-xs font-medium hover:border-gray-400 dark:hover:border-[#444] hover:text-[#ccc]" onclick="selectBudget(this, 'Sur devis')">Sur devis</button>
            </div>
          </div>

          <div class="mb-6">
            <label class="block text-xs text-gray-500 dark:text-[#666] font-semibold mb-2 uppercase tracking-wide">Décrivez votre projet</label>
            <textarea name="description" rows="5" placeholder="Parlez-nous de votre objectif, votre cible, votre deadline…" class="w-full bg-gray-50 dark:bg-[#0d0d0d] border border-gray-300 dark:border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:text-[#444] font-jakarta resize-none">{{ old('description') }}</textarea>
          </div>

          <button type="submit" class="w-full bg-brand-orange text-gray-900 dark:text-white font-bold py-4 rounded-lg text-sm hover:bg-orange-600 transition-colors flex items-center justify-center gap-2">
            Envoyer ma demande <i data-lucide="send" class="w-4 h-4"></i>
          </button>
          <p class="text-center text-xs text-gray-400 dark:text-[#444] mt-3 flex items-center justify-center gap-1">
            <i data-lucide="lock" class="w-3 h-3"></i> Vos données restent confidentielles. Réponse sous 24h.
          </p>
        </form>
      </div>

      <!-- CONTACT INFOS -->
      <div class="flex flex-col gap-5">
        <h2 class="font-jakarta text-2xl font-bold text-gray-900 dark:text-white">Nos coordonnées</h2>

        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5 flex items-start gap-4 hover:border-brand-orange/40 transition-colors">
          <div class="w-10 h-10 bg-orange-50 dark:bg-[#1a0800] border border-brand-orange/20 rounded-lg flex items-center justify-center flex-shrink-0">
            <i data-lucide="map-pin" class="w-5 h-5 text-brand-orange"></i>
          </div>
          <div>
            <p class="text-xs text-gray-500 dark:text-[#555] uppercase tracking-wide font-bold mb-1">Adresse</p>
            <p class="text-sm font-medium text-gray-900 dark:text-white">Lomé, Togo</p>
          </div>
        </div>

        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5 flex items-start gap-4 hover:border-brand-orange/40 transition-colors">
          <div class="w-10 h-10 bg-orange-50 dark:bg-[#1a0800] border border-brand-orange/20 rounded-lg flex items-center justify-center flex-shrink-0">
            <i data-lucide="mail" class="w-5 h-5 text-brand-orange"></i>
          </div>
          <div>
            <p class="text-xs text-gray-500 dark:text-[#555] uppercase tracking-wide font-bold mb-1">Email</p>
            <a href="mailto:thierryamenyah1@gmail.com" class="text-sm font-medium text-gray-900 dark:text-white hover:text-brand-orange transition-colors">thierryamenyah1@gmail.com</a>
            <p class="text-xs text-gray-500 dark:text-[#666]">Réponse sous 24h</p>
          </div>
        </div>

        <div class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-5 flex items-start gap-4 hover:border-brand-orange/40 transition-colors">
          <div class="w-10 h-10 bg-orange-50 dark:bg-[#1a0800] border border-brand-orange/20 rounded-lg flex items-center justify-center flex-shrink-0">
            <i data-lucide="phone" class="w-5 h-5 text-brand-orange"></i>
          </div>
          <div>
            <p class="text-xs text-gray-500 dark:text-[#555] uppercase tracking-wide font-bold mb-1">Téléphone / WhatsApp</p>
            <p class="text-sm font-medium text-gray-900 dark:text-white">+228 93 79 11 88</p>
            <p class="text-xs text-gray-500 dark:text-[#666]">WhatsApp disponible 24/7</p>
          </div>
        </div>

        <!-- WHATSAPP CTA -->
        <a href="https://wa.me/22893791188" target="_blank" rel="noopener noreferrer" class="bg-gradient-to-br from-[#0a1f0a]/10 to-white dark:to-[#0d0d0d] border border-brand-green/20 hover:border-brand-green/45 rounded-xl p-5 flex items-center gap-4 transition-colors group">
          <div class="w-12 h-12 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0 text-white">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.458 5.706 1.459h.008c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
          </div>
          <div class="flex-1">
            <p class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-brand-green transition-colors">Vous préférez WhatsApp ?</p>
            <p class="text-xs text-gray-500 dark:text-[#666]">Envoyez-nous un message directement.</p>
          </div>
          <span class="bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-green-600 transition-colors flex-shrink-0">Ouvrir →</span>
        </a>

        <!-- SOCIALS -->
        <div>
          <p class="text-xs text-gray-500 dark:text-[#555] uppercase tracking-wide font-bold mb-3">Suivez-nous</p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="https://www.instagram.com/genesyshousestudio?igsh=MXBkajNiYzNvdmxzaQ%3D%3D&utm_source=qr" target="_blank" rel="noopener noreferrer" class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-orange/40 transition-colors">
              <svg class="w-5 h-5 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
              </svg>
              <p class="text-[10px] text-gray-500 dark:text-[#555]">@genesyshousestudio</p>
            </a>
            <a href="https://www.tiktok.com/@genesyshouse?_r=1&_t=ZS-96gQPHBkm3k" target="_blank" rel="noopener noreferrer" class="bg-gray-50 dark:bg-[#0d0d0d] border border-gray-200 dark:border-[#1f1f1f] rounded-xl p-4 flex flex-col items-center gap-2 hover:border-brand-orange/40 transition-colors">
              <svg class="w-5 h-5 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
              </svg>
              <p class="text-[10px] text-gray-500 dark:text-[#555]">@genesyshouse</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('scripts')
<script>
  function selectBudget(el, value) {
    document.getElementById('budget-input').value = value;
    document.querySelectorAll('#budget-options .budget-pill').forEach(b => {
      b.className = 'budget-pill border border-gray-300 dark:border-[#2a2a2a] text-gray-500 dark:text-[#666] bg-transparent rounded-full px-4 py-2 text-xs font-medium hover:border-gray-400 dark:hover:border-[#444] hover:text-[#ccc]';
    });
    el.className = 'budget-pill border border-brand-orange text-brand-orange bg-brand-orange/10 rounded-full px-4 py-2 text-xs font-medium';
  }

  // Initialize the correct pill based on old input
  document.addEventListener('DOMContentLoaded', function() {
    const val = document.getElementById('budget-input').value;
    const buttons = document.querySelectorAll('#budget-options button');
    buttons.forEach(btn => {
      if (btn.getAttribute('onclick').includes(val) || btn.innerText === val) {
          btn.className = 'budget-pill border border-brand-orange text-brand-orange bg-brand-orange/10 rounded-full px-4 py-2 text-xs font-medium';
      } else {
          btn.className = 'budget-pill border border-gray-300 dark:border-[#2a2a2a] text-gray-500 dark:text-[#666] bg-transparent rounded-full px-4 py-2 text-xs font-medium hover:border-gray-400 dark:hover:border-[#444] hover:text-[#ccc]';
      }
    });
  });
</script>
@endsection

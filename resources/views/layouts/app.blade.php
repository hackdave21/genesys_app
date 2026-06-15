<!DOCTYPE html>
<html lang="fr" class="dark">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('genesys/frontend/assets/favicon.PNG') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'GENESYS - Agence de Marketing Vidéo Créatif | Lomé, Togo')</title>
  <meta name="description" content="@yield('description', 'GENESYS est une agence de marketing vidéo créatif basée à Lomé, Togo. Nous créons des vidéos qui convertissent : spots publicitaires, Reels, films corporate et événementiels.')">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: {
              orange: '#FF6B2B',
              gold: '#C5A572',
              green: '#00A86B',
              dark: '#0D0D0D',
            }
          },
          fontFamily: {
            jakarta: ['Plus Jakarta Sans', 'sans-serif'],
            caveat: ['Caveat', 'cursive'],
          }
        }
      }
    }
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Caveat:wght@500;600&display=swap" rel="stylesheet">

  <style>
    .lucide { display: inline-block; vertical-align: middle; }
    html { scroll-behavior: smooth; }
    .hero-grid { background-image: radial-gradient(rgba(255, 107, 43, 0.07) 1px, transparent 1px); background-size: 28px 28px; }
    .card-hover { transition: all 0.25s ease; }
    .card-hover:hover { transform: translateY(-3px); border-color: rgba(255, 107, 43, 0.4); }
    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.7; transform: scale(1.15); }
    }
    /* Video Modal */
    #video-modal { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.92); align-items: center; justify-content: center; padding: 1rem; }
    #video-modal.open { display: flex; }
    #video-modal-inner { position: relative; width: 100%; max-width: 900px; background: #0d0d0d; border-radius: 1rem; overflow: hidden; border: 1px solid #2a2a2a; box-shadow: 0 25px 60px rgba(0,0,0,0.8); animation: modalIn 0.25s ease; }
    @keyframes modalIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    #video-modal video, #video-modal iframe { width: 100%; aspect-ratio: 16/9; display: block; border: none; }
    #video-modal-close { position: absolute; top: 0.75rem; right: 0.75rem; width: 2.25rem; height: 2.25rem; background: rgba(0,0,0,0.7); border: 1px solid #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #fff; z-index: 10; transition: background 0.2s; }
    #video-modal-close:hover { background: #FF6B2B; border-color: #FF6B2B; }
  </style>
  @yield('extra-styles')

  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-white dark:bg-[#050505] text-gray-900 dark:text-white font-jakarta antialiased pt-16 flex flex-col min-h-screen">

  <!-- NAV -->
  <nav class="fixed top-0 left-0 right-0 z-50 bg-white/70 dark:bg-[#050505]/70 backdrop-blur-xl backdrop-saturate-150 border-b border-gray-200/50 dark:border-[#1f1f1f]/60 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
      <a href="{{ route('public.index') }}" class="block">
        <img src="{{ asset('genesys/frontend/assets/logo.PNG') }}" alt="GENESYS" class="h-7 w-auto dark:invert dark:hue-rotate-180 transition-all duration-300">
      </a>

      <!-- Desktop Nav Links -->
      <div class="hidden md:flex items-center gap-8">
        <a href="{{ route('public.index') }}" class="{{ request()->routeIs('public.index') ? 'text-brand-orange dark:text-brand-orange text-sm font-bold' : 'text-gray-600 dark:text-[#888] text-sm font-medium hover:text-gray-900 dark:text-white transition-colors' }}">Accueil</a>
        <a href="{{ route('public.portfolio') }}" class="{{ request()->routeIs('public.portfolio') ? 'text-brand-orange dark:text-brand-orange text-sm font-bold' : 'text-gray-600 dark:text-[#888] text-sm font-medium hover:text-gray-900 dark:text-white transition-colors' }}">Portfolio</a>
        <a href="{{ route('public.services') }}" class="{{ request()->routeIs('public.services') ? 'text-brand-orange dark:text-brand-orange text-sm font-bold' : 'text-gray-600 dark:text-[#888] text-sm font-medium hover:text-gray-900 dark:text-white transition-colors' }}">Services</a>
        <a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'text-brand-orange dark:text-brand-orange text-sm font-bold' : 'text-gray-600 dark:text-[#888] text-sm font-medium hover:text-gray-900 dark:text-white transition-colors' }}">À propos</a>

        @auth
          @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="text-brand-green dark:text-brand-green text-sm font-medium hover:text-green-600 transition-colors flex items-center gap-1.5"><i data-lucide="shield-check" class="w-4 h-4"></i> Admin</a>
          @else
            <form method="POST" action="{{ route('logout') }}" class="inline">
              @csrf
              <button type="submit" class="text-gray-600 dark:text-[#888] text-sm font-medium hover:text-gray-900 dark:text-white transition-colors flex items-center gap-1.5"><i data-lucide="log-out" class="w-4 h-4"></i> Déconnexion</button>
            </form>
          @endif
        @else
          <a href="{{ route('login') }}" class="text-gray-600 dark:text-[#888] text-sm font-medium hover:text-gray-900 dark:text-white transition-colors flex items-center gap-1.5"><i data-lucide="user" class="w-4 h-4"></i> Connexion</a>
        @endauth

        <button onclick="toggleTheme()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-[#1a1a1a] text-gray-600 dark:text-[#888] hover:text-brand-orange transition-colors" aria-label="Toggle theme">
          <i data-lucide="moon" class="w-4 h-4 hidden dark:block"></i>
          <i data-lucide="sun" class="w-4 h-4 block dark:hidden"></i>
        </button>
        <a href="{{ route('public.contact') }}" class="bg-brand-orange text-gray-900 dark:text-white text-sm font-semibold px-5 py-2.5 rounded-md hover:bg-orange-600 transition-colors">Demander un devis</a>
      </div>

      <!-- Mobile Controls -->
      <div class="flex md:hidden items-center gap-4">
        <button onclick="toggleTheme()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-[#1a1a1a] text-gray-600 dark:text-[#888] hover:text-brand-orange transition-colors" aria-label="Toggle theme">
          <i data-lucide="moon" class="w-4 h-4 hidden dark:block"></i>
          <i data-lucide="sun" class="w-4 h-4 block dark:hidden"></i>
        </button>
        <button onclick="toggleMobileMenu()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-[#1a1a1a] text-gray-600 dark:text-[#888] hover:text-brand-orange transition-colors" aria-label="Toggle mobile menu">
          <i id="burgerIcon" data-lucide="menu" class="w-5 h-5"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white/95 dark:bg-[#050505]/95 backdrop-blur-md border-b border-gray-200 dark:border-[#1f1f1f] px-6 py-6 transition-all duration-300">
      <div class="flex flex-col gap-4">
        <a href="{{ route('public.index') }}" class="{{ request()->routeIs('public.index') ? 'text-brand-orange dark:text-brand-orange text-base font-bold' : 'text-gray-600 dark:text-[#888] text-base font-medium hover:text-gray-900 dark:text-white transition-colors' }}">Accueil</a>
        <a href="{{ route('public.portfolio') }}" class="{{ request()->routeIs('public.portfolio') ? 'text-brand-orange dark:text-brand-orange text-base font-bold' : 'text-gray-600 dark:text-[#888] text-base font-medium hover:text-gray-900 dark:text-white transition-colors' }}">Portfolio</a>
        <a href="{{ route('public.services') }}" class="{{ request()->routeIs('public.services') ? 'text-brand-orange dark:text-brand-orange text-base font-bold' : 'text-gray-600 dark:text-[#888] text-base font-medium hover:text-gray-900 dark:text-white transition-colors' }}">Services</a>
        <a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'text-brand-orange dark:text-brand-orange text-base font-bold' : 'text-gray-600 dark:text-[#888] text-base font-medium hover:text-gray-900 dark:text-white transition-colors' }}">À propos</a>

        @auth
          @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="text-brand-green dark:text-brand-green text-base font-medium hover:text-green-600 transition-colors flex items-center gap-1.5"><i data-lucide="shield-check" class="w-4.5 h-4.5"></i> Admin</a>
          @else
            <form method="POST" action="{{ route('logout') }}" class="inline">
              @csrf
              <button type="submit" class="text-gray-600 dark:text-[#888] text-base font-medium hover:text-gray-900 dark:text-white transition-colors flex items-center gap-1.5"><i data-lucide="log-out" class="w-4.5 h-4.5"></i> Déconnexion</button>
            </form>
          @endif
        @else
          <a href="{{ route('login') }}" class="text-gray-600 dark:text-[#888] text-base font-medium hover:text-gray-900 dark:text-white transition-colors flex items-center gap-1.5"><i data-lucide="user" class="w-4.5 h-4.5"></i> Connexion</a>
        @endauth

        <div class="border-t border-gray-200 dark:border-[#1f1f1f] pt-4 mt-2">
          <a href="{{ route('public.contact') }}" class="block text-center bg-brand-orange text-gray-900 dark:text-white text-sm font-semibold py-3 rounded-md hover:bg-orange-600 transition-colors">Demander un devis</a>
        </div>
      </div>
    </div>
  </nav>

  @if(session('success'))
    <div class="max-w-7xl mx-auto px-6 mt-4 w-full">
      <div class="bg-brand-green/10 border border-brand-green/30 text-brand-green px-4 py-3 rounded-lg flex items-center gap-2 text-sm font-semibold">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        {{ session('success') }}
      </div>
    </div>
  @endif
  @if($errors->any())
    <div class="max-w-7xl mx-auto px-6 mt-4 w-full">
      <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg flex items-center gap-2 text-sm font-semibold">
        <i data-lucide="alert-circle" class="w-5 h-5"></i>
        {{ $errors->first() }}
      </div>
    </div>
  @endif

  <main class="flex-1 flex flex-col">
    @yield('content')
  </main>

  <!-- FOOTER -->
  <footer class="bg-white dark:bg-[#080808] border-t border-gray-200 dark:border-[#1a1a1a] py-16 mt-auto">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
        <div class="col-span-1 md:col-span-2">
          <a href="{{ route('public.index') }}" class="block mb-4">
            <img src="{{ asset('genesys/frontend/assets/logo.PNG') }}" alt="GENESYS" class="h-8 w-auto dark:invert dark:hue-rotate-180 transition-all duration-300">
          </a>
          <p class="text-sm text-gray-500 dark:text-[#555] leading-relaxed max-w-xs mb-6">Nous ne vendons pas des vidéos. Nous vendons des résultats. La vidéo n'est que notre arme.</p>
          <div class="flex gap-3">
            <a href="https://www.instagram.com/genesyshousestudio" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center bg-gray-100 dark:bg-[#111] border border-gray-300 dark:border-[#222] rounded-lg w-10 h-10 text-gray-500 dark:text-[#666] hover:text-brand-orange dark:hover:text-brand-orange hover:border-brand-orange/40 dark:hover:border-brand-orange/40 transition-colors">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
            </a>
            <a href="https://www.tiktok.com/@genesyshouse" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center bg-gray-100 dark:bg-[#111] border border-gray-300 dark:border-[#222] rounded-lg w-10 h-10 text-gray-500 dark:text-[#666] hover:text-brand-orange dark:hover:text-brand-orange hover:border-brand-orange/40 dark:hover:border-brand-orange/40 transition-colors">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
            </a>
          </div>
        </div>
        <div>
          <p class="text-xs text-gray-400 dark:text-[#444] uppercase tracking-widest font-bold mb-5">Navigation</p>
          <div class="flex flex-col gap-3">
            <a href="{{ route('public.portfolio') }}" class="text-sm text-gray-500 dark:text-[#666] hover:text-gray-900 dark:text-white transition-colors">Portfolio</a>
            <a href="{{ route('public.services') }}" class="text-sm text-gray-500 dark:text-[#666] hover:text-gray-900 dark:text-white transition-colors">Services & Tarifs</a>
            <a href="{{ route('public.about') }}" class="text-sm text-gray-500 dark:text-[#666] hover:text-gray-900 dark:text-white transition-colors">À propos</a>
            <a href="{{ route('public.contact') }}" class="text-sm text-gray-500 dark:text-[#666] hover:text-gray-900 dark:text-white transition-colors">Contact</a>
          </div>
        </div>
        <div>
          <p class="text-xs text-gray-400 dark:text-[#444] uppercase tracking-widest font-bold mb-5">Contact</p>
          <div class="flex flex-col gap-3">
            <p class="text-sm text-gray-500 dark:text-[#666] flex items-center gap-2"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-orange"></i> Lomé, Togo</p>
            <a href="mailto:thierryamenyah1@gmail.com" class="text-sm text-gray-500 dark:text-[#666] hover:text-gray-900 dark:text-white flex items-center gap-2 transition-colors"><i data-lucide="mail" class="w-3.5 h-3.5 text-brand-orange"></i> thierryamenyah1@gmail.com</a>
            <p class="text-sm text-gray-500 dark:text-[#666] flex items-center gap-2"><i data-lucide="phone" class="w-3.5 h-3.5 text-brand-orange"></i>+228 93 79 11 88</p>
          </div>
        </div>
      </div>
      <div class="border-t border-gray-200 dark:border-[#1a1a1a] pt-6 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-400 dark:text-[#444]">
        <span>© {{ date('Y') }} GENESYS House — Lomé, Togo</span>
        <span>Tous droits réservés</span>
      </div>
    </div>
  </footer>

  <!-- CHATBOT WIDGET -->
  <div id="chatbot-widget" class="fixed bottom-6 right-6 z-[99]">
    <div id="chatbot-panel" class="hidden mb-4 w-80 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-[#1f1f1f]">
      <div class="bg-gradient-to-r from-brand-orange to-orange-500 p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center">
            <i data-lucide="bot" class="w-5 h-5 text-white"></i>
          </div>
          <div>
            <p class="text-sm font-bold text-white">GENESYS Assistant</p>
            <p class="text-[11px] text-orange-100">En ligne • Réponse rapide</p>
          </div>
        </div>
        <button onclick="toggleChatbot()" class="text-white/70 hover:text-white transition-colors">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>
      <div class="bg-white dark:bg-[#0d0d0d] p-4 h-64 overflow-y-auto flex flex-col gap-3">
        <div class="bg-orange-50 dark:bg-[#1a0a00] rounded-2xl rounded-tl-sm p-3.5 max-w-[85%] self-start">
          <p class="text-sm text-gray-700 dark:text-[#ccc]">👋 Bonjour ! Je suis l'assistant GENESYS.</p>
          <p class="text-[10px] text-gray-400 dark:text-[#555] mt-1.5">Maintenant</p>
        </div>
        <div class="bg-orange-50 dark:bg-[#1a0a00] rounded-2xl rounded-tl-sm p-3.5 max-w-[85%] self-start">
          <p class="text-sm text-gray-700 dark:text-[#ccc]">Posez-moi vos questions sur nos services, tarifs, ou demandez un devis rapide ! 🎬</p>
          <p class="text-[10px] text-gray-400 dark:text-[#555] mt-1.5">Maintenant</p>
        </div>
      </div>
      <div class="bg-white dark:bg-[#0d0d0d] p-3 border-t border-gray-200 dark:border-[#1f1f1f]">
        <div class="flex gap-2">
          <input type="text" placeholder="Tapez votre message..." class="flex-1 bg-gray-50 dark:bg-[#070707] border border-gray-200 dark:border-[#2a2a2a] rounded-xl px-3.5 py-2.5 text-sm text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-[#555] focus:border-brand-orange outline-none transition-colors">
          <button class="bg-brand-orange text-white rounded-xl px-3.5 py-2.5 hover:bg-orange-600 transition-colors">
            <i data-lucide="send" class="w-4 h-4"></i>
          </button>
        </div>
      </div>
    </div>
    <button onclick="toggleChatbot()" id="chatbot-btn" class="w-16 h-16 rounded-full flex items-center justify-center shadow-lg hover:scale-110 hover:shadow-xl transition-all duration-300 relative group bg-transparent border-0 p-0">
      <img src="{{ asset('genesys/frontend/assets/chatbot.png') }}" alt="GENESYS Assistant" class="chatbot-icon-open w-16 h-16 object-contain drop-shadow-lg">
      <div class="chatbot-icon-close hidden w-14 h-14 bg-gradient-to-r from-brand-orange to-orange-500 rounded-full flex items-center justify-center">
        <i data-lucide="x" class="w-6 h-6 text-white"></i>
      </div>
      <span class="absolute -top-1 -right-1 w-4 h-4 bg-[#00A86B] rounded-full border-2 border-white dark:border-[#050505]" style="animation: pulse 2s infinite;"></span>
    </button>
  </div>

  <script>
    function toggleTheme() {
      const html = document.documentElement;
      if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
      } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
      }
    }

    if (localStorage.getItem('theme') === 'light') {
      document.documentElement.classList.remove('dark');
    }

    function toggleMobileMenu() {
      const menu = document.getElementById('mobileMenu');
      const icon = document.getElementById('burgerIcon');
      if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        icon.setAttribute('data-lucide', 'x');
      } else {
        menu.classList.add('hidden');
        icon.setAttribute('data-lucide', 'menu');
      }
      lucide.createIcons();
    }

    function toggleChatbot() {
      const panel = document.getElementById('chatbot-panel');
      const iconOpen = document.querySelector('.chatbot-icon-open');
      const iconClose = document.querySelector('.chatbot-icon-close');
      if (panel.classList.contains('hidden')) {
        panel.classList.remove('hidden');
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
      } else {
        panel.classList.add('hidden');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
      }
      lucide.createIcons();
    }

    lucide.createIcons();
  </script>
  {{-- GLOBAL VIDEO MODAL --}}
  <div id="video-modal" role="dialog" aria-modal="true" aria-label="Lecteur vidéo" onclick="if(event.target===this)closeVideoPlayer()">
    <div id="video-modal-inner">
      <button id="video-modal-close" onclick="closeVideoPlayer()" aria-label="Fermer">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
      <div id="video-modal-body"></div>
    </div>
  </div>

  <script>
    function openVideoPlayer(url, title) {
      const modal = document.getElementById('video-modal');
      const body  = document.getElementById('video-modal-body');
      body.innerHTML = '';

      // Check if it's a local file path (starts with /storage/ or relative)
      const isLocal = url && (url.startsWith('/storage/') || url.startsWith('blob:') || url.match(/\.(mp4|mov|webm|ogg|avi)$/i));

      if (isLocal) {
        const video = document.createElement('video');
        video.src = url;
        video.controls = true;
        video.autoplay = true;
        video.style.cssText = 'width:100%;aspect-ratio:16/9;display:block;background:#000;';
        body.appendChild(video);
      } else {
        // iframe for YouTube / Vimeo
        const iframe = document.createElement('iframe');
        // Convert watch URL to embed if needed
        let embedUrl = url;
        if (url.includes('youtube.com/watch')) {
          const id = new URL(url).searchParams.get('v');
          if (id) embedUrl = 'https://www.youtube.com/embed/' + id + '?autoplay=1';
        } else if (url.includes('youtu.be/')) {
          const id = url.split('youtu.be/')[1].split('?')[0];
          embedUrl = 'https://www.youtube.com/embed/' + id + '?autoplay=1';
        } else if (url.includes('vimeo.com/')) {
          const id = url.replace(/.*vimeo.com\//, '').split('?')[0];
          embedUrl = 'https://player.vimeo.com/video/' + id + '?autoplay=1';
        } else if (url.includes('youtube.com/embed') || url.includes('player.vimeo.com')) {
          embedUrl = url + (url.includes('?') ? '&' : '?') + 'autoplay=1';
        }
        iframe.src = embedUrl;
        iframe.allow = 'autoplay; fullscreen; picture-in-picture';
        iframe.allowFullscreen = true;
        iframe.style.cssText = 'width:100%;aspect-ratio:16/9;display:block;border:none;';
        body.appendChild(iframe);
      }

      modal.classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeVideoPlayer() {
      const modal = document.getElementById('video-modal');
      const body  = document.getElementById('video-modal-body');
      modal.classList.remove('open');
      body.innerHTML = '';
      document.body.style.overflow = '';
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closeVideoPlayer();
    });
  </script>

  @yield('scripts')
</body>
</html>

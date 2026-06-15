<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('genesys/admin/assets/favicon.PNG') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin') - GENESYS Admin</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: { orange: '#FF6B2B', gold: '#C5A572', green: '#00A86B' }
          },
          fontFamily: {
            jakarta: ['Plus Jakarta Sans', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .lucide { display: inline-block; vertical-align: middle; }
    html, body { height: 100%; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .nav-active { background-color: #141414; color: #fff !important; }
    .nav-active i { color: #FF6B2B; }
  </style>
  @yield('extra-styles')
</head>
<body class="bg-[#070707] text-white font-jakarta antialiased h-screen flex overflow-hidden">

  {{-- Sidebar Backdrop --}}
  <div id="sidebar-backdrop" class="fixed inset-0 bg-black/60 z-40 hidden transition-opacity duration-300" onclick="toggleSidebar()"></div>

  {{-- SIDEBAR --}}
  <aside id="sidebar" class="w-56 bg-[#0d0d0d] border-r border-[#1f1f1f] flex flex-col flex-shrink-0 fixed inset-y-0 left-0 z-50 -translate-x-full md:translate-x-0 md:static transition-transform duration-300 ease-in-out">
    <div class="p-5 border-b border-[#1f1f1f] flex items-center justify-between">
      <div>
        <a href="{{ route('public.index') }}" class="block mb-2">
          <img src="{{ asset('genesys/admin/assets/logo.PNG') }}" alt="GENESYS" class="h-7 w-auto">
        </a>
        <span class="text-[10px] text-[#444] uppercase tracking-widest font-medium">Admin Panel</span>
      </div>
      <button onclick="toggleSidebar()" class="md:hidden text-[#888] hover:text-white p-1">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <nav class="flex-1 p-4 flex flex-col gap-1 overflow-y-auto hide-scrollbar">
      <p class="text-[9px] text-[#333] uppercase tracking-widest font-bold px-3 py-2">Général</p>

      <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#888] hover:bg-[#141414] hover:text-white font-medium transition-colors" data-route="admin.dashboard">
        <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Tableau de bord
      </a>
      <a href="{{ route('admin.devis.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#888] hover:bg-[#141414] hover:text-white font-medium transition-colors" data-route="admin.devis.index">
        <i data-lucide="clipboard-list" class="w-4 h-4"></i> Demandes de Devis
      </a>
      <a href="{{ route('admin.projects.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#888] hover:bg-[#141414] hover:text-white font-medium transition-colors" data-route="admin.projects.index">
        <i data-lucide="clapperboard" class="w-4 h-4"></i> Projets & Kanban
      </a>
      <a href="{{ route('admin.clients.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#888] hover:bg-[#141414] hover:text-white font-medium transition-colors" data-route="admin.clients.index">
        <i data-lucide="users" class="w-4 h-4"></i> Clients & Contacts
      </a>

      <p class="text-[9px] text-[#333] uppercase tracking-widest font-bold px-3 py-2 mt-3">Contenu Site</p>

      {{-- Témoignages --}}
      <div>
        <button onclick="toggleSubmenu('submenu-temoignages')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-[#888] hover:bg-[#141414] hover:text-white font-medium transition-colors">
          <span class="flex items-center gap-3">
            <i data-lucide="message-square" class="w-4 h-4"></i> Témoignages
          </span>
          <i data-lucide="chevron-down" id="arrow-temoignages" class="w-3.5 h-3.5 transition-transform duration-200"></i>
        </button>
        <div id="submenu-temoignages" class="hidden flex-col gap-1 pl-9 mt-1">
          <a href="{{ route('admin.testimonials.create') }}" class="flex items-center gap-2 py-1.5 text-xs text-[#888] hover:text-white transition-colors">
            Ajouter un témoignage
          </a>
          <a href="{{ route('admin.testimonials.index') }}" class="flex items-center gap-2 py-1.5 text-xs text-[#888] hover:text-white transition-colors">
            Liste témoignages
          </a>
        </div>
      </div>

      {{-- Vidéos --}}
      <div>
        <button onclick="toggleSubmenu('submenu-videos')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-[#888] hover:bg-[#141414] hover:text-white font-medium transition-colors">
          <span class="flex items-center gap-3">
            <i data-lucide="video" class="w-4 h-4"></i> Vidéos
          </span>
          <i data-lucide="chevron-down" id="arrow-videos" class="w-3.5 h-3.5 transition-transform duration-200"></i>
        </button>
        <div id="submenu-videos" class="hidden flex-col gap-1 pl-9 mt-1">
          <a href="{{ route('admin.videos.create') }}" class="flex items-center gap-2 py-1.5 text-xs text-[#888] hover:text-white transition-colors">
            Ajouter une vidéo
          </a>
          <a href="{{ route('admin.videos.index') }}" class="flex items-center gap-2 py-1.5 text-xs text-[#888] hover:text-white transition-colors">
            Liste vidéos
          </a>
        </div>
      </div>

      <div class="mt-auto pt-4 border-t border-[#1a1a1a]">
        <a href="{{ route('public.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#888] hover:bg-[#141414] hover:text-white font-medium transition-colors">
          <i data-lucide="external-link" class="w-4 h-4"></i> Voir le site
        </a>
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#888] hover:bg-red-900/20 hover:text-red-400 font-medium transition-colors text-left">
            <i data-lucide="log-out" class="w-4 h-4"></i> Déconnexion
          </button>
        </form>
      </div>
    </nav>
  </aside>

  {{-- MAIN --}}
  <div class="flex-1 flex flex-col overflow-hidden">
    {{-- TOP BAR --}}
    <header class="h-14 bg-[#0a0a0a] border-b border-[#1a1a1a] px-4 md:px-6 flex items-center justify-between flex-shrink-0">
      <div class="flex items-center gap-3">
        <button onclick="toggleSidebar()" class="md:hidden text-[#888] hover:text-white transition-colors p-1">
          <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <h1 class="font-jakarta text-base md:text-lg font-bold">@yield('page-title', 'Administration')</h1>
      </div>
      <div class="flex items-center gap-4">
        {{-- Flash success toast --}}
        @if(session('success'))
          <span id="flash-toast" class="hidden sm:flex items-center gap-2 bg-brand-green/10 border border-brand-green/30 text-brand-green text-xs font-semibold px-3 py-1.5 rounded-lg">
            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
            {{ session('success') }}
          </span>
        @endif
        <div class="flex items-center gap-2">
          <div class="w-7 h-7 md:w-8 md:h-8 bg-brand-orange rounded-full flex items-center justify-center text-xs font-bold">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
          </div>
          <span class="text-xs md:text-sm text-[#888] hidden sm:inline">{{ auth()->user()->name ?? 'Admin' }}</span>
        </div>
      </div>
    </header>

    {{-- CONTENT --}}
    <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-[#070707]">

      {{-- Global error display --}}
      @if($errors->any())
        <div class="mb-4 bg-red-500/10 border border-red-500/30 rounded-xl p-4 flex items-start gap-3">
          <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5"></i>
          <ul class="text-xs text-red-400 space-y-1">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

  <script>
    // Sidebar toggle
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const backdrop = document.getElementById('sidebar-backdrop');
      if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
      } else {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
      }
    }

    // Submenu toggle
    function toggleSubmenu(id) {
      const menu = document.getElementById(id);
      const key = id.replace('submenu-', '');
      const arrow = document.getElementById('arrow-' + key);
      const isHidden = menu.classList.contains('hidden');
      menu.classList.toggle('hidden');
      menu.classList.toggle('flex');
      if (arrow) arrow.style.transform = isHidden ? 'rotate(180deg)' : '';
    }

    // Auto-open submenus based on current URL
    document.addEventListener('DOMContentLoaded', function() {
      const path = window.location.pathname;
      if (path.includes('/admin/testimonials')) {
        toggleSubmenu('submenu-temoignages');
      }
      if (path.includes('/admin/videos')) {
        toggleSubmenu('submenu-videos');
      }

      // Auto-hide flash toast after 4s
      const toast = document.getElementById('flash-toast');
      if (toast) {
        setTimeout(() => toast.style.opacity = '0', 3500);
        setTimeout(() => toast.style.display = 'none', 4000);
      }

      lucide.createIcons();
    });
  </script>

  @yield('scripts')
</body>
</html>

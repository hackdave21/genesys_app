<!DOCTYPE html>
<html lang="fr" class="dark">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('genesys/frontend/assets/favicon.PNG') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Authentification - GENESYS House')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: { orange: '#FF6B2B', gold: '#C5A572', green: '#00A86B', dark: '#0D0D0D' }
          },
          fontFamily: {
            jakarta: ['Plus Jakarta Sans', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">
  <style>
    .lucide {
      display: inline-block;
      vertical-align: middle;
    }

    .hero-grid {
      background-image: radial-gradient(rgba(255, 107, 43, 0.05) 1px, transparent 1px);
      background-size: 28px 28px;
    }

    input {
      transition: all 0.25s ease;
    }

    input:focus {
      border-color: #FF6B2B !important;
      outline: none;
      box-shadow: 0 0 0 3px rgba(255, 107, 43, 0.15);
    }
  </style>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body
  class="bg-white dark:bg-[#050505] text-gray-900 dark:text-white font-jakarta antialiased min-h-screen flex flex-col justify-between hero-grid relative">

  <!-- TOP BAR / BACK LINK -->
  <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between z-10">
    <a href="{{ route('public.index') }}"
      class="flex items-center gap-2 text-sm text-gray-500 hover:text-brand-orange transition-colors">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour à l'accueil
    </a>
    <button onclick="toggleTheme()"
      class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-[#1a1a1a] text-gray-600 dark:text-[#888] hover:text-brand-orange transition-colors"
      aria-label="Toggle theme">
      <i data-lucide="moon" class="w-4 h-4 hidden dark:block"></i>
      <i data-lucide="sun" class="w-4 h-4 block dark:hidden"></i>
    </button>
  </header>

  <main class="w-full flex-1 flex items-center justify-center p-6 z-10">
    @yield('content')
  </main>

  <!-- MINIMAL FOOTER -->
  <footer
    class="w-full py-6 text-center text-xs text-gray-400 dark:text-[#444] z-10 border-t border-gray-200/50 dark:border-[#1f1f1f]/50 bg-white/50 dark:bg-[#050505]/50">
    © {{ date('Y') }} GENESYS House — Lomé, Togo. Tous droits réservés.
  </footer>

  <script>
    // Theme logic
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

    // Init theme
    if (localStorage.getItem('theme') === 'light') {
      document.documentElement.classList.remove('dark');
    }

    lucide.createIcons();
  </script>

</body>

</html>

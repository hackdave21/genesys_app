<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="{{ asset('genesys/admin/assets/favicon.PNG') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion Administration - GENESYS Admin</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: { brand: { orange: '#FF6B2B', gold: '#C5A572', green: '#00A86B' } },
          fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] }
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .lucide { display: inline-block; vertical-align: middle; }
    .hero-grid { background-image: radial-gradient(rgba(255,107,43,0.06) 1px, transparent 1px); background-size: 28px 28px; }
    input { transition: all 0.25s ease; }
    input:focus { border-color: #FF6B2B !important; outline: none; box-shadow: 0 0 0 3px rgba(255,107,43,0.2); }
  </style>
</head>
<body class="bg-[#070707] text-white font-jakarta antialiased min-h-screen flex flex-col justify-between hero-grid relative">

  <main class="w-full flex-1 flex items-center justify-center p-6 z-10">
    <div class="w-full max-w-md bg-[#0d0d0d] border border-[#1f1f1f] rounded-2xl p-8 shadow-2xl shadow-black/80 relative overflow-hidden">
      <div class="absolute -top-24 -left-24 w-48 h-48 bg-brand-orange/10 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-brand-gold/10 rounded-full blur-3xl pointer-events-none"></div>

      <div class="relative z-10 flex flex-col items-center">
        <a href="{{ route('public.index') }}" class="mb-4 block">
          <img src="{{ asset('genesys/admin/assets/logo.PNG') }}" alt="GENESYS Logo" class="h-9 w-auto">
        </a>
        <span class="text-[10px] text-[#444] uppercase tracking-widest font-semibold mb-6">G-PANEL LOGIN</span>

        <div class="text-center mb-8">
          <h1 class="font-jakarta text-2xl font-bold mb-1">Espace Administratif</h1>
          <p class="text-xs text-[#555]">Veuillez vous authentifier pour accéder au tableau de bord</p>
        </div>

        {{-- Error Messages --}}
        @if($errors->any())
          <div class="w-full mb-5 bg-red-500/10 border border-red-500/30 rounded-xl p-3 flex items-start gap-2">
            <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5"></i>
            <p class="text-xs text-red-400">{{ $errors->first() }}</p>
          </div>
        @endif

        <form class="w-full" method="POST" action="{{ route('admin.login') ?? url('/admin/login') }}">
          @csrf

          <div class="mb-5">
            <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Email</label>
            <div class="relative">
              <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                required
                placeholder="admin@genesys.tg"
                class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg pl-10 pr-4 py-3 text-sm text-white placeholder:text-[#333] font-jakarta"
              >
              <i data-lucide="mail" class="w-4 h-4 text-[#444] absolute left-3.5 top-3.5"></i>
            </div>
          </div>

          <div class="mb-6">
            <div class="flex justify-between items-center mb-2">
              <label class="block text-xs text-[#555] font-semibold uppercase tracking-wide">Mot de passe</label>
            </div>
            <div class="relative">
              <input
                type="password"
                name="password"
                id="password"
                required
                placeholder="••••••••"
                class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg pl-10 pr-10 py-3 text-sm text-white placeholder:text-[#333] font-jakarta"
              >
              <i data-lucide="lock" class="w-4 h-4 text-[#444] absolute left-3.5 top-3.5"></i>
              <button type="button" onclick="togglePwd()" class="absolute right-3.5 top-3.5 text-[#444] hover:text-white transition-colors">
                <i data-lucide="eye" class="w-4 h-4" id="pwd-eye"></i>
              </button>
            </div>
          </div>

          <div class="flex items-center justify-between mb-8">
            <label class="flex items-center gap-2 text-xs text-[#555] cursor-pointer">
              <input type="checkbox" name="remember" class="accent-[#FF6B2B] rounded border-[#2a2a2a] bg-[#070707]">
              <span>Session persistante (30 jours)</span>
            </label>
          </div>

          <button type="submit" class="w-full bg-gradient-to-r from-brand-orange to-orange-600 text-white font-bold py-3.5 rounded-lg text-sm hover:from-orange-600 hover:to-orange-700 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-orange-950/20">
            Accéder au tableau de bord <i data-lucide="shield-check" class="w-4 h-4"></i>
          </button>
        </form>
      </div>
    </div>
  </main>

  <footer class="w-full py-6 text-center text-xs text-[#333] z-10 border-t border-[#111] bg-[#080808]/50">
    © {{ date('Y') }} GENESYS Admin — Lomé, Togo. Accès réservé aux administrateurs autorisés.
  </footer>

  <script>
    function togglePwd() {
      const input = document.getElementById('password');
      const icon = document.getElementById('pwd-eye');
      if (input.type === 'password') {
        input.type = 'text';
        icon.setAttribute('data-lucide', 'eye-off');
      } else {
        input.type = 'password';
        icon.setAttribute('data-lucide', 'eye');
      }
      lucide.createIcons();
    }
    lucide.createIcons();
  </script>
</body>
</html>

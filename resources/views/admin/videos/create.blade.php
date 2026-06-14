@extends('layouts.admin')

@section('title', 'Ajouter une Vidéo')
@section('page-title', 'Nouvelle Vidéo Portfolio')

@section('content')

<div class="max-w-2xl mx-auto">

  <a href="{{ route('admin.videos.index') }}" class="inline-flex items-center gap-2 text-xs text-[#666] hover:text-white transition-colors mb-6">
    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Retour à la liste
  </a>

  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-2xl p-6 md:p-8">
    <h2 class="font-jakarta text-lg font-bold mb-6 flex items-center gap-2">
      <i data-lucide="video-off" class="w-5 h-5 text-brand-orange"></i>
      Ajouter une vidéo au portfolio
    </h2>

    <form method="POST" action="{{ route('admin.videos.store') }}" enctype="multipart/form-data" class="space-y-5">
      @csrf

      {{-- Title --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Titre de la vidéo *</label>
        <input type="text" name="title" value="{{ old('title') }}" required
          placeholder="Ex : Spot publicitaire Ecobank 2026"
          class="w-full bg-[#070707] border {{ $errors->has('title') ? 'border-red-500' : 'border-[#2a2a2a]' }} rounded-lg px-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all">
        @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Category --}}
        <div>
          <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Catégorie *</label>
          <select name="category" required
            class="w-full bg-[#070707] border {{ $errors->has('category') ? 'border-red-500' : 'border-[#2a2a2a]' }} rounded-lg px-4 py-3 text-sm text-white focus:border-brand-orange outline-none transition-all cursor-pointer">
            <option value="">Sélectionner...</option>
            @foreach(['Publicité', 'Événement', 'Reels', 'Corporate'] as $cat)
              <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
          @error('category')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Client --}}
        <div>
          <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Client</label>
          <input type="text" name="client" value="{{ old('client') }}"
            placeholder="Ex : Ecobank Togo"
            class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all">
        </div>
      </div>

      {{-- Video URL --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">URL YouTube / Vimeo *</label>
        <div class="relative">
          <input type="url" name="video_url" value="{{ old('video_url') }}" required
            placeholder="https://www.youtube.com/watch?v=..."
            class="w-full bg-[#070707] border {{ $errors->has('video_url') ? 'border-red-500' : 'border-[#2a2a2a]' }} rounded-lg pl-10 pr-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all">
          <i data-lucide="link" class="w-4 h-4 text-[#444] absolute left-3.5 top-3.5"></i>
        </div>
        <p class="text-[10px] text-[#555] mt-1">Accepte les URLs YouTube et Vimeo. La miniature YouTube sera auto-générée.</p>
        @error('video_url')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Description --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Description</label>
        <textarea name="description" rows="3"
          placeholder="Brève description du projet vidéo..."
          class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all resize-none">{{ old('description') }}</textarea>
      </div>

      {{-- Thumbnail upload (optional) --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Miniature personnalisée (optionnel)</label>
        <div class="border-2 border-dashed border-[#2a2a2a] rounded-xl p-6 text-center hover:border-brand-orange/50 transition-colors cursor-pointer" onclick="document.getElementById('thumbnail').click()">
          <i data-lucide="image-plus" class="w-8 h-8 text-[#444] mx-auto mb-2"></i>
          <p class="text-xs text-[#555]">Cliquer pour sélectionner une image (JPG, PNG, WebP)</p>
          <p id="file-name" class="text-xs text-brand-orange mt-2 hidden"></p>
        </div>
        <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="hidden" onchange="showFileName(this)">
        @error('thumbnail')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Featured --}}
      <div class="flex items-center gap-3 p-4 bg-[#111] border border-[#2a2a2a] rounded-xl">
        <input type="checkbox" name="is_featured" id="is_featured" value="1"
          {{ old('is_featured') ? 'checked' : '' }}
          class="w-4 h-4 accent-[#FF6B2B] cursor-pointer">
        <label for="is_featured" class="flex flex-col cursor-pointer">
          <span class="text-sm font-medium text-white">Mettre en avant</span>
          <span class="text-xs text-[#555]">Cette vidéo apparaîtra en priorité dans le portfolio</span>
        </label>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="submit"
          class="flex-1 bg-gradient-to-r from-brand-orange to-orange-600 text-white font-bold py-3.5 rounded-lg text-sm hover:from-orange-600 hover:to-orange-700 transition-all flex items-center justify-center gap-2">
          <i data-lucide="upload-cloud" class="w-4 h-4"></i> Publier la vidéo
        </button>
        <a href="{{ route('admin.videos.index') }}"
          class="px-5 py-3.5 border border-[#2a2a2a] text-[#888] hover:text-white rounded-lg text-sm font-medium transition-colors">
          Annuler
        </a>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
  function showFileName(input) {
    const label = document.getElementById('file-name');
    if (input.files && input.files[0]) {
      label.textContent = '✓ ' + input.files[0].name;
      label.classList.remove('hidden');
    }
  }
</script>
@endsection

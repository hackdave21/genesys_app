@extends('layouts.admin')

@section('title', 'Modifier la Vidéo')
@section('page-title', 'Modifier la Vidéo')

@section('content')

<div class="max-w-2xl mx-auto">

  <a href="{{ route('admin.videos.index') }}" class="inline-flex items-center gap-2 text-xs text-[#666] hover:text-white transition-colors mb-6">
    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Retour à la liste
  </a>

  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-2xl p-6 md:p-8">
    <h2 class="font-jakarta text-lg font-bold mb-6 flex items-center gap-2">
      <i data-lucide="edit-3" class="w-5 h-5 text-brand-orange"></i>
      Modifier : {{ $video->title }}
    </h2>

    {{-- Current video preview --}}
    @if($video->video_url)
      <div class="mb-5 p-4 bg-[#111] border border-[#2a2a2a] rounded-xl">
        <p class="text-xs text-[#555] font-semibold uppercase tracking-wide mb-3">Vidéo actuelle</p>
        @if(str_starts_with($video->video_url, '/storage/') || str_starts_with($video->video_url, 'http://') || str_starts_with($video->video_url, 'https://') && str_contains($video->video_url, '/storage/'))
          <video src="{{ $video->video_url }}" class="w-full max-h-48 rounded-lg object-cover" controls></video>
        @else
          <div class="flex items-center gap-3">
            <i data-lucide="external-link" class="w-4 h-4 text-brand-orange"></i>
            <a href="{{ $video->video_url }}" target="_blank" class="text-sm text-brand-orange hover:underline truncate">{{ $video->video_url }}</a>
          </div>
        @endif
      </div>
    @endif

    {{-- Current thumbnail preview --}}
    @if($video->thumbnail_url)
      <div class="mb-5">
        <p class="text-xs text-[#555] font-semibold uppercase tracking-wide mb-2">Miniature actuelle</p>
        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="h-32 w-auto rounded-lg object-cover border border-[#2a2a2a]">
      </div>
    @endif

    <form method="POST" action="{{ route('admin.videos.update', $video) }}" enctype="multipart/form-data" class="space-y-5">
      @csrf
      @method('PUT')

      {{-- Title --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Titre de la vidéo *</label>
        <input type="text" name="title" value="{{ old('title', $video->title) }}" required
          class="w-full bg-[#070707] border {{ $errors->has('title') ? 'border-red-500' : 'border-[#2a2a2a]' }} rounded-lg px-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all">
        @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Catégorie *</label>
          <select name="category" required
            class="w-full bg-[#070707] border {{ $errors->has('category') ? 'border-red-500' : 'border-[#2a2a2a]' }} rounded-lg px-4 py-3 text-sm text-white focus:border-brand-orange outline-none transition-all cursor-pointer">
            @foreach(['Publicité', 'Événement', 'Reels', 'Corporate'] as $cat)
              <option value="{{ $cat }}" {{ old('category', $video->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
          @error('category')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Client</label>
          <input type="text" name="client" value="{{ old('client', $video->client) }}"
            class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all">
        </div>
      </div>

      {{-- Replace video --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Remplacer la vidéo (optionnel)</label>
        <div class="border-2 border-dashed border-[#2a2a2a] rounded-xl p-6 text-center hover:border-brand-orange/50 transition-colors cursor-pointer"
          onclick="document.getElementById('video_file').click()">
          <i data-lucide="upload" class="w-8 h-8 text-[#444] mx-auto mb-2"></i>
          <p class="text-xs text-[#555]">Choisir un nouveau fichier vidéo pour remplacer l'actuel</p>
          <p class="text-[10px] text-[#444] mt-1">MP4, MOV, WebM, AVI — Max 100 Mo</p>
          <div id="video-preview-container" class="hidden mt-4">
            <video id="video-preview" class="w-full max-h-40 rounded-lg object-cover mx-auto" controls></video>
          </div>
          <p id="video-file-name" class="text-xs text-brand-orange mt-2 hidden font-medium"></p>
        </div>
        <input type="file" name="video_file" id="video_file" accept="video/mp4,video/mov,video/ogg,video/webm,video/avi" class="hidden" onchange="handleVideoSelect(this)">
        @error('video_file')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Description --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Description</label>
        <textarea name="description" rows="3"
          class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all resize-none">{{ old('description', $video->description) }}</textarea>
      </div>

      {{-- Thumbnail replacement --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Remplacer la miniature (optionnel)</label>
        <div class="border-2 border-dashed border-[#2a2a2a] rounded-xl p-6 text-center hover:border-brand-orange/50 transition-colors cursor-pointer" onclick="document.getElementById('thumbnail').click()">
          <i data-lucide="image" class="w-8 h-8 text-[#444] mx-auto mb-2"></i>
          <p class="text-xs text-[#555]">Choisir une nouvelle image pour remplacer l'actuelle</p>
          <p id="thumb-file-name" class="text-xs text-brand-orange mt-2 hidden"></p>
        </div>
        <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="hidden" onchange="showThumbName(this)">
      </div>

      {{-- Status --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Statut *</label>
        <select name="status" required class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-4 py-3 text-sm text-white focus:border-brand-orange outline-none transition-all cursor-pointer">
          <option value="visible" {{ old('status', $video->status) === 'visible' ? 'selected' : '' }}>Visible</option>
          <option value="archive" {{ old('status', $video->status) === 'archive' ? 'selected' : '' }}>Archivé</option>
        </select>
      </div>

      {{-- Featured --}}
      <div class="flex items-center gap-3 p-4 bg-[#111] border border-[#2a2a2a] rounded-xl">
        <input type="checkbox" name="is_featured" id="is_featured" value="1"
          {{ old('is_featured', $video->is_featured) ? 'checked' : '' }}
          class="w-4 h-4 accent-[#FF6B2B] cursor-pointer">
        <label for="is_featured" class="flex flex-col cursor-pointer">
          <span class="text-sm font-medium text-white">Mettre en avant</span>
          <span class="text-xs text-[#555]">Cette vidéo apparaîtra en priorité dans le portfolio</span>
        </label>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="submit"
          class="flex-1 bg-gradient-to-r from-brand-orange to-orange-600 text-white font-bold py-3.5 rounded-lg text-sm hover:from-orange-600 hover:to-orange-700 transition-all flex items-center justify-center gap-2">
          <i data-lucide="save" class="w-4 h-4"></i> Mettre à jour
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
  function handleVideoSelect(input) {
    if (input.files && input.files[0]) {
      const file = input.files[0];
      const label = document.getElementById('video-file-name');
      const previewContainer = document.getElementById('video-preview-container');
      const preview = document.getElementById('video-preview');

      label.textContent = '✓ ' + file.name + ' (' + (file.size / (1024 * 1024)).toFixed(1) + ' Mo)';
      label.classList.remove('hidden');

      const url = URL.createObjectURL(file);
      preview.src = url;
      previewContainer.classList.remove('hidden');
    }
  }

  function showThumbName(input) {
    const label = document.getElementById('thumb-file-name');
    if (input.files && input.files[0]) {
      label.textContent = '✓ ' + input.files[0].name;
      label.classList.remove('hidden');
    }
  }
</script>
@endsection

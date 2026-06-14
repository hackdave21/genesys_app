@extends('layouts.admin')

@section('title', 'Modifier un Témoignage')
@section('page-title', 'Modifier le Témoignage')

@section('content')

<div class="max-w-2xl mx-auto">

  <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center gap-2 text-xs text-[#666] hover:text-white transition-colors mb-6">
    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Retour à la liste
  </a>

  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-2xl p-6 md:p-8">
    <h2 class="font-jakarta text-lg font-bold mb-6 flex items-center gap-2">
      <i data-lucide="edit-3" class="w-5 h-5 text-brand-orange"></i>
      Modifier le témoignage de {{ $testimonial->client_name }}
    </h2>

    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" class="space-y-5">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Nom du client *</label>
          <input type="text" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required
            class="w-full bg-[#070707] border {{ $errors->has('client_name') ? 'border-red-500' : 'border-[#2a2a2a]' }} rounded-lg px-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all">
          @error('client_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Entreprise / Fonction *</label>
          <input type="text" name="company_role" value="{{ old('company_role', $testimonial->company_role) }}" required
            class="w-full bg-[#070707] border {{ $errors->has('company_role') ? 'border-red-500' : 'border-[#2a2a2a]' }} rounded-lg px-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all">
          @error('company_role')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Rating --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-3 uppercase tracking-wide">Note (étoiles) *</label>
        <div class="flex gap-2" id="star-rating">
          @for($i = 1; $i <= 5; $i++)
            <button type="button" data-value="{{ $i }}" onclick="setRating({{ $i }})"
              class="star-btn text-3xl transition-all {{ old('rating', $testimonial->rating) >= $i ? 'text-brand-gold' : 'text-[#333]' }}">★</button>
          @endfor
        </div>
        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', $testimonial->rating) }}">
        @error('rating')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Content --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Témoignage *</label>
        <textarea name="content" rows="5" required
          class="w-full bg-[#070707] border {{ $errors->has('content') ? 'border-red-500' : 'border-[#2a2a2a]' }} rounded-lg px-4 py-3 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none transition-all resize-none">{{ old('content', $testimonial->content) }}</textarea>
        @error('content')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Status --}}
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Statut de publication</label>
        <div class="flex gap-3">
          @foreach(['published' => 'Publié (visible sur le site)', 'draft' => 'Brouillon (caché)'] as $val => $lbl)
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="status" value="{{ $val }}"
                {{ old('status', $testimonial->status) === $val ? 'checked' : '' }}
                class="accent-[#FF6B2B]">
              <span class="text-sm text-[#888]">{{ $lbl }}</span>
            </label>
          @endforeach
        </div>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="submit"
          class="flex-1 bg-gradient-to-r from-brand-orange to-orange-600 text-white font-bold py-3.5 rounded-lg text-sm hover:from-orange-600 hover:to-orange-700 transition-all flex items-center justify-center gap-2">
          <i data-lucide="save" class="w-4 h-4"></i> Mettre à jour
        </button>
        <a href="{{ route('admin.testimonials.index') }}"
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
  function setRating(value) {
    document.getElementById('rating-input').value = value;
    document.querySelectorAll('#star-rating .star-btn').forEach((btn, index) => {
      btn.classList.toggle('text-brand-gold', index < value);
      btn.classList.toggle('text-[#333]', index >= value);
    });
  }
  // Add hover effect
  document.querySelectorAll('#star-rating .star-btn').forEach((btn, i) => {
    btn.addEventListener('mouseover', () => {
      document.querySelectorAll('#star-rating .star-btn').forEach((b, j) => {
        b.style.color = j <= i ? '#C5A572' : '#333';
      });
    });
    btn.addEventListener('mouseleave', () => {
      const current = parseInt(document.getElementById('rating-input').value);
      document.querySelectorAll('#star-rating .star-btn').forEach((b, j) => {
        b.style.color = j < current ? '#C5A572' : '#333';
      });
    });
  });
</script>
@endsection

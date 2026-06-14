@extends('layouts.admin')

@section('title', 'Projets & Kanban')
@section('page-title', 'Projets & Kanban')

@section('extra-styles')
.kanban-col { min-height: 200px; }
.project-card { cursor: grab; }
.project-card:active { cursor: grabbing; }
.drag-over { border-color: #FF6B2B !important; background-color: rgba(255,107,43,0.05); }
@endsection

@section('content')

{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
  {{-- View toggle --}}
  <div class="flex bg-[#111] border border-[#2a2a2a] rounded-lg p-1 gap-1">
    <a href="{{ route('admin.projects.index', ['view' => 'kanban']) }}"
      class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors
        {{ $view === 'kanban' ? 'bg-[#1f1f1f] text-white' : 'text-[#888] hover:text-white' }}">
      <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i> Kanban
    </a>
    <a href="{{ route('admin.projects.index', ['view' => 'list']) }}"
      class="flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors
        {{ $view === 'list' ? 'bg-[#1f1f1f] text-white' : 'text-[#888] hover:text-white' }}">
      <i data-lucide="list" class="w-3.5 h-3.5"></i> Liste
    </a>
  </div>

  {{-- Add Project --}}
  <button onclick="openCreateModal()"
    class="flex items-center gap-2 bg-gradient-to-r from-brand-orange to-orange-600 text-white font-bold px-4 py-2.5 rounded-lg text-sm hover:from-orange-600 hover:to-orange-700 transition-all">
    <i data-lucide="plus" class="w-4 h-4"></i> Nouveau projet
  </button>
</div>

@if($view === 'kanban')
{{-- ─── KANBAN VIEW ─────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 overflow-x-auto pb-4">
  @php
    $steps = [
      'Scripting' => ['icon' => 'pen-line',    'color' => 'blue-400',   'bg' => 'blue-500/10'],
      'Tournage'  => ['icon' => 'video',        'color' => 'purple-400', 'bg' => 'purple-500/10'],
      'Montage'   => ['icon' => 'scissors',     'color' => 'brand-orange','bg' => 'brand-orange/10'],
      'Terminé'   => ['icon' => 'check-circle', 'color' => 'brand-green','bg' => 'brand-green/10'],
    ];
  @endphp

  @foreach($steps as $step => $cfg)
    @php $colProjects = $projects->where('step', $step); @endphp
    <div class="flex flex-col gap-3" id="col-{{ Str::slug($step) }}" data-step="{{ $step }}"
      ondragover="onDragOver(event)" ondrop="onDrop(event, '{{ $step }}')">

      {{-- Column Header --}}
      <div class="flex items-center justify-between px-1">
        <div class="flex items-center gap-2">
          <div class="w-6 h-6 bg-{{ $cfg['bg'] }} rounded-md flex items-center justify-center">
            <i data-lucide="{{ $cfg['icon'] }}" class="w-3.5 h-3.5 text-{{ $cfg['color'] }}"></i>
          </div>
          <span class="text-sm font-bold text-white">{{ $step }}</span>
        </div>
        <span class="bg-[#1a1a1a] text-[#888] text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $colProjects->count() }}</span>
      </div>

      {{-- Project Cards --}}
      <div class="kanban-col flex flex-col gap-3 border border-[#1a1a1a] rounded-xl p-3 bg-[#080808] transition-colors"
        id="drop-{{ Str::slug($step) }}">

        @forelse($colProjects as $project)
          <div class="project-card bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl p-4 hover:border-brand-orange/20 transition-colors"
            draggable="true" data-id="{{ $project->id }}"
            ondragstart="onDragStart(event, {{ $project->id }})">

            {{-- Priority badge --}}
            <div class="flex items-start justify-between mb-2">
              <span class="text-[9px] font-bold px-2 py-0.5 rounded-full uppercase
                {{ $project->priority === 'Urgent' ? 'bg-red-500/15 text-red-400' :
                  ($project->priority === 'Moyen'  ? 'bg-brand-gold/15 text-brand-gold' :
                  'bg-[#222] text-[#555]') }}">
                {{ $project->priority }}
              </span>
              <button onclick="openEditModal({{ $project->id }}, {{ $project->progress }}, '{{ $project->priority }}', '{{ $project->deadline }}')"
                class="text-[#444] hover:text-white transition-colors">
                <i data-lucide="more-horizontal" class="w-4 h-4"></i>
              </button>
            </div>

            <h4 class="text-sm font-semibold text-white mb-1 leading-snug">{{ $project->title }}</h4>

            @if($project->client)
              <p class="text-xs text-[#555] mb-3 flex items-center gap-1">
                <i data-lucide="user" class="w-3 h-3"></i> {{ $project->client->name }}
              </p>
            @endif

            {{-- Progress Bar --}}
            <div class="mb-3">
              <div class="flex justify-between items-center mb-1.5">
                <span class="text-[10px] text-[#555]">Progression</span>
                <span class="text-[10px] font-bold text-brand-orange">{{ $project->progress }}%</span>
              </div>
              <div class="w-full bg-[#1a1a1a] rounded-full h-1.5">
                <div class="bg-gradient-to-r from-brand-orange to-orange-400 h-1.5 rounded-full transition-all"
                  style="width: {{ $project->progress }}%"></div>
              </div>
            </div>

            {{-- Deadline --}}
            @if($project->deadline)
              <p class="text-[10px] text-[#555] flex items-center gap-1">
                <i data-lucide="calendar" class="w-3 h-3"></i>
                {{ \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') }}
                @if(\Carbon\Carbon::parse($project->deadline)->isPast() && $project->step !== 'Terminé')
                  <span class="text-red-400 font-bold ml-1">● En retard</span>
                @endif
              </p>
            @endif

            {{-- Step Change --}}
            <form method="POST" action="{{ route('admin.projects.update-step', $project) }}" class="mt-3">
              @csrf
              @method('PATCH')
              <select name="step" onchange="this.form.submit()"
                class="w-full bg-[#111] border border-[#2a2a2a] text-[#888] text-xs rounded-lg px-2 py-1.5 focus:outline-none cursor-pointer hover:border-brand-orange/50 transition-colors">
                @foreach(['Scripting','Tournage','Montage','Terminé'] as $s)
                  <option value="{{ $s }}" {{ $project->step === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
              </select>
            </form>
          </div>
        @empty
          <div class="text-center py-8 text-[#333]">
            <i data-lucide="inbox" class="w-6 h-6 mx-auto mb-2"></i>
            <p class="text-[10px]">Aucun projet</p>
          </div>
        @endforelse
      </div>
    </div>
  @endforeach
</div>

@else
{{-- ─── LIST VIEW ────────────────────────────────────────────────────────── --}}
<div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-xl overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full min-w-[700px] border-collapse">
      <thead>
        <tr class="border-b border-[#1a1a1a]">
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Projet</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Client</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Étape</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Progression</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Priorité</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Délai</th>
          <th class="text-left text-[#555] text-[10px] uppercase tracking-wide py-3 px-4 font-bold">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($projects as $project)
          <tr class="border-b border-[#111] hover:bg-[#111]/50 transition-colors">
            <td class="py-3 px-4 text-sm font-medium text-white">{{ $project->title }}</td>
            <td class="py-3 px-4 text-xs text-[#888]">{{ $project->client?->name ?? '—' }}</td>
            <td class="py-3 px-4">
              <span class="text-[10px] font-bold px-2 py-1 rounded-full
                @if($project->step === 'Scripting') bg-blue-500/15 text-blue-400
                @elseif($project->step === 'Tournage') bg-purple-500/15 text-purple-400
                @elseif($project->step === 'Montage') bg-brand-orange/15 text-brand-orange
                @else bg-brand-green/15 text-brand-green
                @endif">
                {{ $project->step }}
              </span>
            </td>
            <td class="py-3 px-4">
              <div class="flex items-center gap-2">
                <div class="w-20 bg-[#1a1a1a] rounded-full h-1.5">
                  <div class="bg-brand-orange h-1.5 rounded-full" style="width: {{ $project->progress }}%"></div>
                </div>
                <span class="text-xs text-[#888]">{{ $project->progress }}%</span>
              </div>
            </td>
            <td class="py-3 px-4">
              <span class="text-[10px] font-bold px-2 py-0.5 rounded-full
                {{ $project->priority === 'Urgent' ? 'text-red-400' : ($project->priority === 'Moyen' ? 'text-brand-gold' : 'text-[#555]') }}">
                {{ $project->priority }}
              </span>
            </td>
            <td class="py-3 px-4 text-xs text-[#555]">
              {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') : '—' }}
            </td>
            <td class="py-3 px-4">
              <div class="flex items-center gap-2">
                <button onclick="openEditModal({{ $project->id }}, {{ $project->progress }}, '{{ $project->priority }}', '{{ $project->deadline ?? '' }}')"
                  class="text-[#666] hover:text-white transition-colors" title="Modifier">
                  <i data-lucide="edit-3" class="w-4 h-4"></i>
                </button>
                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Supprimer ce projet ?')"
                    class="text-[#666] hover:text-red-400 transition-colors" title="Supprimer">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="py-16 text-center">
              <i data-lucide="inbox" class="w-10 h-10 text-[#333] mx-auto mb-3"></i>
              <p class="text-sm text-[#555]">Aucun projet créé.</p>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endif

{{-- ─── CREATE PROJECT MODAL ─────────────────────────────────────────── --}}
<div id="create-modal" class="fixed inset-0 bg-black/80 z-50 hidden items-center justify-center p-4">
  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-2xl p-6 w-full max-w-md">
    <div class="flex items-center justify-between mb-5">
      <h3 class="font-bold text-base flex items-center gap-2">
        <i data-lucide="plus-circle" class="w-4 h-4 text-brand-orange"></i> Nouveau Projet
      </h3>
      <button onclick="closeCreateModal()" class="text-[#555] hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <form method="POST" action="{{ route('admin.projects.store') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-1 uppercase tracking-wide">Titre *</label>
        <input type="text" name="title" required placeholder="Ex : Spot NSIA Assurances"
          class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-4 py-2.5 text-sm text-white placeholder:text-[#333] focus:border-brand-orange outline-none">
      </div>
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-1 uppercase tracking-wide">Client</label>
        <select name="client_id" class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-4 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
          <option value="">Aucun client associé</option>
          @foreach($clients as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-[#555] font-semibold mb-1 uppercase tracking-wide">Priorité</label>
          <select name="priority" class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
            <option value="Bas">Bas</option>
            <option value="Moyen" selected>Moyen</option>
            <option value="Urgent">Urgent</option>
          </select>
        </div>
        <div>
          <label class="block text-xs text-[#555] font-semibold mb-1 uppercase tracking-wide">Délai</label>
          <input type="date" name="deadline" class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
        </div>
      </div>
      <button type="submit" class="w-full bg-gradient-to-r from-brand-orange to-orange-600 text-white font-bold py-3 rounded-lg text-sm hover:from-orange-600 hover:to-orange-700 transition-all">
        Créer le projet
      </button>
    </form>
  </div>
</div>

{{-- ─── EDIT PROGRESS MODAL ──────────────────────────────────────────── --}}
<div id="edit-modal" class="fixed inset-0 bg-black/80 z-50 hidden items-center justify-center p-4">
  <div class="bg-[#0d0d0d] border border-[#1f1f1f] rounded-2xl p-6 w-full max-w-sm">
    <div class="flex items-center justify-between mb-5">
      <h3 class="font-bold text-base">Modifier le projet</h3>
      <button onclick="closeEditModal()" class="text-[#555] hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
    </div>
    <form id="edit-form" method="POST" class="space-y-4">
      @csrf
      @method('PATCH')
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-2 uppercase tracking-wide">Progression : <span id="progress-val">0</span>%</label>
        <input type="range" name="progress" id="progress-slider" min="0" max="100" step="5" value="0"
          oninput="document.getElementById('progress-val').textContent = this.value"
          class="w-full accent-[#FF6B2B]">
      </div>
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-1 uppercase tracking-wide">Priorité</label>
        <select name="priority" id="edit-priority" class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
          <option value="Bas">Bas</option>
          <option value="Moyen">Moyen</option>
          <option value="Urgent">Urgent</option>
        </select>
      </div>
      <div>
        <label class="block text-xs text-[#555] font-semibold mb-1 uppercase tracking-wide">Délai</label>
        <input type="date" name="deadline" id="edit-deadline" class="w-full bg-[#070707] border border-[#2a2a2a] rounded-lg px-3 py-2.5 text-sm text-white focus:border-brand-orange outline-none">
      </div>
      <button type="submit" class="w-full bg-gradient-to-r from-brand-orange to-orange-600 text-white font-bold py-3 rounded-lg text-sm hover:from-orange-600 hover:to-orange-700 transition-all">
        Mettre à jour
      </button>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
  // Create modal
  function openCreateModal() {
    const m = document.getElementById('create-modal');
    m.classList.remove('hidden'); m.classList.add('flex');
  }
  function closeCreateModal() {
    const m = document.getElementById('create-modal');
    m.classList.add('hidden'); m.classList.remove('flex');
  }

  // Edit modal
  function openEditModal(id, progress, priority, deadline) {
    document.getElementById('edit-form').action = `/admin/projets/${id}/progress`;
    const slider = document.getElementById('progress-slider');
    slider.value = progress;
    document.getElementById('progress-val').textContent = progress;
    document.getElementById('edit-priority').value = priority;
    document.getElementById('edit-deadline').value = deadline;
    const m = document.getElementById('edit-modal');
    m.classList.remove('hidden'); m.classList.add('flex');
  }
  function closeEditModal() {
    const m = document.getElementById('edit-modal');
    m.classList.add('hidden'); m.classList.remove('flex');
  }

  // Drag & Drop Kanban
  let draggedId = null;
  function onDragStart(event, id) {
    draggedId = id;
    event.dataTransfer.effectAllowed = 'move';
  }
  function onDragOver(event) {
    event.preventDefault();
    event.currentTarget.querySelector('[id^="drop-"]')?.classList.add('drag-over');
  }
  function onDrop(event, step) {
    event.preventDefault();
    event.currentTarget.querySelector('[id^="drop-"]')?.classList.remove('drag-over');
    if (!draggedId) return;

    fetch(`/admin/projets/${draggedId}/step`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
        'Accept': 'application/json',
      },
      body: JSON.stringify({ step })
    }).then(r => r.json()).then(() => location.reload());
  }
</script>
@endsection

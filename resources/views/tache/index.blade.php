@extends('layouts.app')

@section('title', 'Kanban - ' . $projet->nom . ' | Kollab')

@section('content')

<!-- Header -->
<header class=" flex flex-col md:flex-row md:items-center md:justify-between gap-4">
  <!-- Titre et description -->
  <div>
    <h1 class="text-2xl font-bold text-purple-400 tracking-tight">
      Tâches du projet : {{ \Illuminate\Support\Str::limit($projet->nom, 20, ' ...') }}
    </h1>
    <p class="text-gray-400 text-sm">Gérez vos tâches en fonction de leur statut</p>
  </div>

<!-- Barre de recherche compacte, bouton à droite du statut -->
<div class="flex items-center gap-2">

    <!-- Boutons d'action style gros -->
    <a href="{{ route('projet.show', $projet->id_projet) }}"
      class="group relative inline-flex items-center gap-2 bg-gray-900/60 text-gray-200 border border-gray-700 rounded-xl px-6 py-3 text-base shadow-md hover:bg-gray-800 hover:shadow-lg transition duration-300 h-12">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-300 group-hover:-translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
      <span>Retour</span>
    </a>

@if($sprints->isNotEmpty())
  @auth
    @if(Auth::id() === $projet->chef_id)
      <a href="{{ route('epic.create', ['id_projet' => $projet->id_projet, 'sprint_id' => $sprintActuel?->id_sprint]) }}"
         class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-6 py-3 text-base rounded-xl shadow-lg hover:shadow-2xl hover:scale-[1.03] transition duration-300 h-12">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 group-hover:rotate-6 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Créer un epic</span>
      </a>
    @endif
  @endauth
@php
    $membreRole = $projet->membres()
        ->where('id_utilisateur', Auth::id())
        ->first()?->role;
@endphp

@if($projet->epics->isNotEmpty() && $membreRole !== 'lecteur')
    <a href="{{ route('tache.create', ['id_projet' => $projet->id_projet, 'sprint_id' => $sprintActuel?->id_sprint]) }}"
       class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-6 py-3 text-base rounded-xl shadow-lg hover:shadow-2xl hover:scale-[1.03] transition duration-300 h-12">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 group-hover:rotate-6 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      <span>Créer une tâche</span>
    </a>
@endif

@endif

  </div>
</header>
<div class="w-full flex justify-center items-center mt-3 mb-4">
  <!-- Bouton RESET intégré à gauche dans le flex -->
  <button
    type="button"
    id="resetBtn"
    title="Réinitialiser la recherche"
    class="flex items-center justify-center w-11 h-11 rounded-full bg-gray-700 hover:bg-gray-600 border border-gray-800 shadow text-gray-400 transition-opacity mr-3"
    style="transition: background 0.2s; {{ request('search') ? '' : 'opacity:0; pointer-events:none;' }}">
    <!-- SVG de la croix -->
    <svg xmlns="http://www.w3.org/2000/svg"
      class="h-7 w-7"
      fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 18L18 6M6 6l12 12"/>
    </svg>
  </button>

  <!-- Barre de recherche centrée -->
  <form method="GET"
    action="{{ route('tache.index', ['id_projet' => $projet->id_projet, 'sprint_id' => $sprintActuel?->id_sprint]) }}"
    id="searchForm"
    class="flex items-center gap-4 bg-gray-900 rounded-2xl px-2 py-2 border border-gray-700 shadow">
    <div class="relative">
      <input
        type="text"
        name="search"
        placeholder="Chercher une tâche ou un membre"
        value="{{ request('search') }}"
        class="pl-3 pr-3 py-2 text-base rounded-lg border border-gray-700 bg-gray-800 text-gray-100 w-72"
        id="searchInput"
      >
    </div>
    <select
      name="statut"
      class="px-3 py-2 text-base rounded-lg border border-gray-700 bg-gray-800 text-gray-100 focus:outline-none focus:ring focus:ring-purple-600 min-w-[150px]">
      <option value="">Tous Statuts</option>
      <option value="à faire" {{ request('statut') == 'à faire' ? 'selected' : '' }}>À faire</option>
      <option value="en cours" {{ request('statut') == 'en cours' ? 'selected' : '' }}>En cours</option>
      <option value="terminée" {{ request('statut') == 'terminée' ? 'selected' : '' }}>Terminée</option>
    </select>
    <button type="submit" id="searchBtn"
      class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-700 hover:bg-gray-600 border border-gray-800 text-gray-400"
      title="Rechercher"
      style="transition: background 0.2s;">
        <svg xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </button>
  </form>
</div>


<div class="container mx-auto px-4">

  <!-- Bandeau avec sélecteur et infos du sprint -->
  @if($sprints->isNotEmpty())
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl border border-gray-700 p-5 mb-5 shadow-lg">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- Infos du sprint actuel -->
        <div class="flex-1">
          @if($sprintActuel)
            <div class="flex items-center gap-3 mb-1">
              <h3 class="text-1xl font-bold text-purple-300">
                {{ $sprintActuel->nom }}
              </h3>
                @php
                    $now = now()->startOfDay();
                    $debut = \Carbon\Carbon::parse($sprintActuel->date_debut)->startOfDay();
                    $fin = \Carbon\Carbon::parse($sprintActuel->date_fin)->endOfDay();
                    $isEnCours = $debut <= $now && $fin >= $now;
                @endphp

                @if($isEnCours)
                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-300 border border-green-500/30">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                        En cours
                    </span>
                @endif

            </div>
            <p class="text-sm text-gray-400 flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Du {{ \Carbon\Carbon::parse($sprintActuel->date_debut)->format('d/m/Y') }}
              au {{ \Carbon\Carbon::parse($sprintActuel->date_fin)->format('d/m/Y') }}
            </p>
          @else
            <h3 class="text-xl font-semibold text-gray-400">Aucun sprint sélectionné</h3>
          @endif
        </div>

        <!-- Sélecteur de sprint -->
        <div class="flex items-center gap-3">
          <label for="sprint_id" class="text-sm font-medium text-gray-300 whitespace-nowrap">
            Changer de sprint :
          </label>
          <form method="GET" class="inline-block">
            <select name="sprint_id"
                    id="sprint_id"
                    onchange="this.form.submit()"
                    class="px-4 py-2 bg-gray-800 text-purple-200 border border-purple-500/50 rounded-lg hover:border-purple-400 focus:border-purple-400 focus:ring-2 focus:ring-purple-500/20 transition cursor-pointer">
              @foreach ($sprints as $sprint)
                <option value="{{ $sprint->id_sprint }}"
                  @if($sprintActuel && $sprint->id_sprint == $sprintActuel->id_sprint) selected @endif>
                  {{ $sprint->nom }}
                </option>
              @endforeach
            </select>
          </form>
        </div>
      </div>
    </div>
    @else
    <div class="bg-gray-900/50 border border-gray-700 rounded-xl p-6 mb-8 text-center">
        <p class="text-gray-400 italic">
        Aucun sprint disponible pour ce projet.
        </p>
                @auth
                    @if(Auth::id() === $projet->chef_id)
                        <a href="{{ route('projet.sprints.create', $projet->id_projet) }}"
                          class="mt-4 group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-lg hover:shadow-2xl hover:scale-[1.03] transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:rotate-6 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Nouveau sprint</span>
                        </a>
                    @endif
                @endauth
    </div>
    @endif

  <!-- Génération des couleurs -->
@php
function generateColorFromId($id, &$previousHue = null) {
    // Calcul de la teinte (HSL hue)
    $hue = ($id * 137.508) % 360;

    if ($previousHue !== null && abs($hue - $previousHue) < 40) {
        $hue = fmod($hue + 60, 360);
    }

    $previousHue = $hue;

    $saturation = 60 + ($id % 20);
    $lightness = 45 + ($id % 15);

    return [
        'bg' => "background: linear-gradient(135deg,
                    hsla({$hue}, {$saturation}%, {$lightness}%, 0.2),
                    hsla({$hue}, {$saturation}%, " . ($lightness - 5) . "%, 0.2));",
        'border' => "border-color: hsla({$hue}, {$saturation}%, {$lightness}%, 0.3);",
        'text' => "color: hsl({$hue}, {$saturation}%, 75%);",
        'badge' => "background: hsla({$hue}, {$saturation}%, {$lightness}%, 0.25);
                    color: hsl({$hue}, {$saturation}%, 85%);"
    ];
}

$epicColors = [];
$previousHue = null;

foreach ($epics as $epic) {
    $epicColors[$epic->id_epic] = generateColorFromId($epic->id_epic, $previousHue);
}
@endphp

<!-- Organisation Kanban avec layout amélioré -->
<div class="flex flex-col lg:flex-row gap-6">

  <!-- COLONNE ÉPICS - Fixe sur desktop, scrollable sur mobile -->
  <div class="w-full lg:w-1/4 lg:flex-shrink-0">
    <div class="flex items-center justify-between mb-2">
      <h2 class="text-base font-bold text-purple-300">Epics du projet</h2>
      <span class="text-xs text-gray-500">{{ $epics->count() }} epic{{ $epics->count() > 1 ? 's' : '' }}</span>
    </div>

    <!-- Tous les epics (compact) -->
    @if($epics->count() > 0)
      <div class="epic-card mx-2 cursor-pointer rounded-lg p-3 border border-gray-700 shadow bg-gray-800/40 hover:bg-gray-700/60 transition-all duration-200 mb-2"
           data-epic-id="all"
           data-text-color="#9CA3AF"
           onclick="filterByEpic('all', '#9CA3AF')">
        <h3 class="text-sm font-semibold text-gray-400">Tous les epics</h3>
      </div>
    @endif

    <!-- Liste des epics avec scroll -->
    <div class="flex flex-col gap-2 max-h-[330px] overflow-y-auto pr-2 p-2 custom-scrollbar">
      @forelse($epics as $epic)
        @php
            $nbTaches = $sprintActuel ? $taches->where('id_epic', $epic->id_epic)->count() : 0;
            $color = $epicColors[$epic->id_epic];
            preg_match('/color:\s*([^;]+)/', $color['text'], $matches);
            $textColor = $matches[1] ?? '#fff';
        @endphp

        <div class="epic-card cursor-pointer rounded-lg p-3 border shadow relative hover:brightness-110 transition-all duration-200"
             style="{{ $color['bg'] }} {{ $color['border'] }}"
             data-epic-id="{{ $epic->id_epic }}"
             data-text-color="{{ $textColor }}"
             onclick="filterByEpic({{ $epic->id_epic }}, '{{ $textColor }}')">

          <span class="absolute top-2 right-2 px-2 py-0.5 text-[10px] font-semibold rounded" style="{{ $color['badge'] }}">
            <span class="inline-block w-1.5 h-1.5 rounded-full mr-1" style="background-color: currentColor;"></span>
            {{ ucfirst($epic->priorite) }}
          </span>

          <h3 class="text-sm font-semibold mb-1 pr-12" style="{{ $color['text'] }}">{{ $epic->titre }}</h3>
          <p class="text-[11px] text-gray-400 mb-1">
            {{ Str::limit($epic->description, 80, '…') ?: '' }}
          </p>

          <div class="flex items-center justify-between mt-1">
            <span class="text-[11px] text-gray-500">
              {{ $nbTaches }} tâche{{ $nbTaches > 1 ? 's' : '' }}
            </span>
            @auth
              @if(Auth::id() === $projet->chef_id)
                <div class="flex gap-2" onclick="event.stopPropagation()">
                  <a href="{{ route('epic.edit', [
                      'id_projet' => $projet->id_projet,
                      'id_epic' => $epic->id_epic,
                      'sprint_id' => $sprintActuel?->id_sprint
                  ]) }}"
                  class="hover:bg-yellow-500/20 rounded p-1 transition"
                  title="Modifier"
                  aria-label="Modifier">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                  </a>
                  <form action="{{ route('epic.delete', [$projet->id_projet, $epic->id_epic]) }}"
                    method="POST"
                    onsubmit="return confirm('Supprimer cet epic et toutes ses tâches associées ?')"
                    class="inline">
                    @csrf @method('DELETE')
                    <input type="hidden" name="sprint_id" value="{{ $sprintActuel?->id_sprint }}">
                    <button type="submit"
                            class="hover:bg-red-600/20 rounded p-1 transition"
                            title="Supprimer"
                            aria-label="Supprimer">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-300 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </button>
                  </form>
                </div>
              @endif
            @endauth
          </div>
        </div>
      @empty
        <div class="bg-gray-900 rounded-lg p-3 border border-gray-700 text-gray-500 italic text-sm">
          Aucun epic dans ce projet
        </div>
      @endforelse
    </div>
  </div>

  <!-- CONTENEUR KANBAN - Scroll horizontal sur mobile/tablette -->
<div class="flex-1 overflow-x-auto overflow-y-hidden p-4 custom-scrollbar-horizontal" data-project-id="{{ $projet->id_projet }}">
    <div class="flex flex-row gap-4 justify-start items-start min-w-min">
      @foreach (['à faire', 'en cours', 'terminée'] as $statut)
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-4 shadow-xl border border-gray-800 flex-shrink-0 w-full sm:w-80 h-[400px] flex flex-col"
             data-statut="{{ $statut }}">

          <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-700">
            <span class="w-3 h-3 rounded-full
              {{ $statut === 'à faire' ? 'bg-red-500' : ($statut === 'en cours' ? 'bg-yellow-500' : 'bg-green-500') }}">
            </span>
            <h2 class="text-lg font-semibold capitalize text-purple-300">
              {{ $statut === 'à faire' ? 'À faire' : ucfirst($statut) }}
            </h2>
            @php
              $tachesStatut = $sprintActuel ? $taches->where('statut', $statut) : collect();
              $count = $tachesStatut->count();
            @endphp
            <span class="text-sm text-gray-500 font-normal">({{ $count }})</span>
          </div>

          <div class="flex-1 overflow-y-auto pr-1 custom-scrollbar">
            @forelse ($tachesStatut as $tache)
              @php
                $tacheColor = isset($tache->id_epic) && isset($epicColors[$tache->id_epic])
                  ? $epicColors[$tache->id_epic]['badge']
                  : 'background: rgba(107, 114, 128, 0.2); color: rgb(209, 213, 219);';
              @endphp

              <div class="task-card w-full bg-gray-900/70 border border-gray-700 rounded-lg shadow p-3 mb-2 hover:bg-gray-800 transition cursor-pointer relative"
                  data-task-epic="{{ $tache->id_epic }}"
                  data-tache-id="{{ $tache->id_tache }}"
                  onclick="openTaskModal{{ $tache->id_tache }}()">

                @if($tache->epic)
                  <div class="mb-1">
                    <span class="inline-block px-1 py-1 text-xs font-semibold rounded" style="{{ $tacheColor }}">
                      {{ $tache->epic->titre }}
                    </span>
                  </div>
                @endif

                <h3 class="text-sm font-medium text-gray-300 truncate">
                  {{ $tache->titre }}
                </h3>

                <div class="flex items-center gap-2 mt-1 text-xs">
                  @if($tache->date_fin_prevue)
                    @php
                      $isLate = $tache->date_fin_prevue->lt(now()) && $tache->statut !== 'terminée';
                    @endphp
                    <div class="flex items-center gap-1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $isLate ? 'text-red-400' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                      <span class="{{ $isLate ? 'text-red-400 font-semibold' : 'text-gray-400' }}">
                        {{ $tache->date_fin_prevue->format('d/m') }}
                        @if($isLate)
                          <span class="ml-1 text-xs font-bold bg-red-700/60 text-white px-2 py-0.5 rounded">Retard</span>
                        @endif
                      </span>
                    </div>
                  @endif
                </div>

                @if($tache->utilisateur)
                  <div class="absolute bottom-2 right-2">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full text-white font-bold text-normal shadow border border-gray-500"
                      style="background: {{ $tache->utilisateur->couleur ?? '#7c3aed' }}; border-width:1px"
                      title="{{ $tache->utilisateur->name }}">
                      {{ strtoupper(substr($tache->utilisateur->name, 0, 1)) }}
                    </div>
                  </div>
                @endif
              </div>

              <!-- Modal pour cette tâche -->
<div id="taskModal{{ $tache->id_tache }}" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
  <div class="bg-gray-900 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-gray-800 ring-2 ring-purple-800/30"
       onclick="event.stopPropagation()">

    <!-- En-tête -->
    <div class="sticky top-0 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 border-b border-gray-800 p-6 flex justify-between items-start rounded-t-2xl">
      <div class="flex-1">
        <div class="flex items-center gap-3 mb-3 flex-wrap">
          @if($tache->epic)
            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full shadow bg-purple-600/30 text-purple-200 border border-purple-700"
                  style="{{ $tacheColor }}">
              {{ $tache->epic->titre }}
            </span>
          @endif

          <!-- Statut -->
          <span id="modalStatut{{ $tache->id_tache }}"
                class="px-3 py-1 text-xs font-semibold rounded-full shadow
                {{ $tache->statut === 'à faire' ? 'bg-red-600/20 text-red-300 border border-red-700/30' : ($tache->statut === 'en cours' ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-600/30' : 'bg-green-600/20 text-green-300 border border-green-700/30') }}">
            {{ ucfirst($tache->statut) }}
          </span>

          @if($tache->utilisateur)
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-800/80 text-white font-medium gap-2 shadow border border-gray-700"
                  style="font-size:1rem; line-height:1.3rem;">
              <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
              </svg>
              {{ $tache->utilisateur->name }}
            </span>
          @endif
        </div>
        <h2 class="text-2xl font-bold text-gray-100 mb-1 tracking-tight leading-tight">{{ $tache->titre }}</h2>
      </div>
      <button onclick="closeTaskModal{{ $tache->id_tache }}()"
              class="text-gray-400 hover:text-white transition ml-6 rounded-full p-2 hover:scale-110 duration-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Contenu -->
    <div class="p-6 space-y-8">
      <!-- Description -->
      <div>
        <h3 class="text-base font-semibold text-purple-300 mb-2 uppercase tracking-wide">Description</h3>
        <p class="text-gray-300">{{ $tache->description ?: 'Aucune description' }}</p>
      </div>
      <hr class="border-gray-700 my-4"/>

      <!-- Priorité, dates -->
      <div class="grid grid-cols-2 md:grid-cols-2 gap-6">
        <div>
          <h3 class="text-sm font-semibold text-gray-400 mb-2">Priorité</h3>
          <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full shadow
                {{ $tache->priorite === 'haute' ? 'bg-red-600/20 text-red-300 border border-red-700/30' :
                   ($tache->priorite === 'moyenne' ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-600/30' :
                     'bg-green-600/20 text-green-300 border border-green-700/30') }}">
            <span class="inline-block w-2 h-2 rounded-full mr-1.5" style="background-color: currentColor;"></span>
            {{ ucfirst($tache->priorite) }}
          </span>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-gray-400 mb-2">Date création</h3>
          <p class="text-gray-300">{{ \Carbon\Carbon::parse($tache->date_creation)->format('d/m/Y') }}</p>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-gray-400 mb-2">Date de début</h3>
          <p class="text-gray-300">{{ \Carbon\Carbon::parse($tache->date_debut)->format('d/m/Y à H:i') }}</p>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-gray-400 mb-2">Date de fin prévue</h3>
          <p class="text-gray-300">{{ \Carbon\Carbon::parse($tache->date_fin_prevue)->format('d/m/Y à H:i') }}</p>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="sticky bottom-0 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 border-t border-gray-800 p-6 flex flex-wrap justify-end gap-4 rounded-b-2xl">
      <button onclick="closeTaskModal{{ $tache->id_tache }}()"
              class="group relative inline-flex items-center gap-2 bg-gray-800 text-gray-100 border border-gray-700 rounded-xl px-5 py-2.5 shadow hover:bg-purple-700/80 hover:text-white transition duration-300 hover:scale-105">
        <svg class="w-5 h-5 text-purple-300 group-hover:-translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <span>Retour</span>
      </button>
@php
    $isChef = (Auth::id() == $projet->chef_id);
@endphp

@if(Auth::id() == $tache->id_utilisateur || $isChef || $membreRole === 'editeur')
    <a href="{{ route('tache.edit', [$projet->id_projet, $tache->id_tache]) }}"
      class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-5 py-2.5 rounded-xl shadow hover:shadow-2xl hover:scale-105 transition duration-300">
      <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
      </svg>
      <span>Modifier</span>
    </a>
@endif

@if($isChef)
    <form action="{{ route('tache.delete', [$projet->id_projet, $tache->id_tache]) }}"
          method="POST"
          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')"
          class="inline-block">
        @csrf @method('DELETE')
        <button type="submit"
                class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-rose-700 text-white font-medium px-5 py-2.5 rounded-xl shadow hover:shadow-2xl hover:scale-110 transition duration-300">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>Supprimer</span>
        </button>
    </form>
      @endif
    </div>
  </div>
</div>


              <!-- Scripts modal -->
              @push('scripts')
                <script>
                  function openTaskModal{{ $tache->id_tache }}() {
                    document.getElementById('taskModal{{ $tache->id_tache }}').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                  }

                  function closeTaskModal{{ $tache->id_tache }}() {
                    document.getElementById('taskModal{{ $tache->id_tache }}').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                  }

                  document.getElementById('taskModal{{ $tache->id_tache }}').addEventListener('click', function(e) {
                    if (e.target === this) {
                      closeTaskModal{{ $tache->id_tache }}();
                    }
                  });

                  document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                      closeTaskModal{{ $tache->id_tache }}();
                    }
                  });
                </script>
              @endpush
            @empty
            @endforelse
          </div>
        </div>
      @endforeach
    </div>
  </div>

</div>

</div>
@php
    $membreRole = $projet->membres()
        ->where('id_utilisateur', Auth::id())
        ->first()?->role ?? null;
@endphp

@endsection
@push('styles')
<style>
.custom-scrollbar::-webkit-scrollbar {
  width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: #000000ff;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #240f57ff;
  border-radius: 10px;
  border: 1px solid #000000;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #2d2d2d;
}

.custom-scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #240f57ff #000000;
}

/* Scrollbar horizontal - Conteneur Kanban */
.custom-scrollbar-horizontal::-webkit-scrollbar {
  height: 8px;
}

.custom-scrollbar-horizontal::-webkit-scrollbar-track {
  background: #000000ff;
  border-radius: 10px;
}

.custom-scrollbar-horizontal::-webkit-scrollbar-thumb {
  background: #240f57ff;
  border-radius: 10px;
  border: 1px solid #000000;
}

.custom-scrollbar-horizontal::-webkit-scrollbar-thumb:hover {
  background: #2d2d2d;
}

.custom-scrollbar-horizontal {
  scrollbar-width: thin;
  scrollbar-color: #240f57ff #000000;
}

@media (max-width: 1024px) {
  .epic-card {
    flex-shrink: 0;
  }
}
</style>
@endpush

@push('scripts')
<script>
let selectedEpicId = 'all';

function filterByEpic(epicId, textColor) {
  selectedEpicId = epicId;

  document.querySelectorAll('.epic-card').forEach(card => {
    card.classList.remove('ring-2');
    card.style.boxShadow = '';
  });

  const selectedCard = document.querySelector(`.epic-card[data-epic-id="${epicId}"]`);
  if (selectedCard) {
    selectedCard.classList.add('ring-2', 'brightness-125');
    selectedCard.style.boxShadow = `0 0 0 2px ${textColor}`;
  }

  const allTasks = document.querySelectorAll('.task-card');

  allTasks.forEach(task => {
    const taskEpicId = task.getAttribute('data-task-epic');

    if (epicId === 'all' || taskEpicId == epicId) {
      task.style.display = 'block';
      task.classList.remove('hidden');
    } else {
      task.style.display = 'none';
      task.classList.add('hidden');
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  filterByEpic('all', '#9CA3AF');
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Init drag & drop si pas lecteur
    if (window.membreRole !== 'lecteur') {
        initKanbanDragDrop();
    }

    // Modifier le curseur si lecteur
    if (window.membreRole === 'lecteur') {
        document.querySelectorAll('.task-card').forEach(card => {
            card.setAttribute('draggable', 'false');
            card.style.cursor = 'pointer';
        });
    }
});


function initKanbanDragDrop() {
  const taskCards = document.querySelectorAll('.task-card');
  const columns = document.querySelectorAll('[data-statut]');

  // Rendre les cartes draggables
  taskCards.forEach(card => {
    card.setAttribute('draggable', 'true');

    card.addEventListener('dragstart', function(e) {
      this.classList.add('opacity-50');
      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/html', this.innerHTML);
      e.dataTransfer.setData('taskId', this.getAttribute('data-tache-id'));
    });

    card.addEventListener('dragend', function(e) {
      this.classList.remove('opacity-50');
    });
  });

  // Gérer les colonnes comme zones de drop
  columns.forEach(column => {
    const scrollContainer = column.querySelector('.flex-1');

    column.addEventListener('dragover', function(e) {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'move';
      this.classList.add('bg-purple-900/30', 'ring-2', 'ring-purple-500');
    });

    column.addEventListener('dragleave', function(e) {
      // Vérifier que on quitte vraiment la colonne
      if (e.target === this) {
        this.classList.remove('bg-purple-900/30', 'ring-2', 'ring-purple-500');
      }
    });

    column.addEventListener('drop', function(e) {
      e.preventDefault();
      e.stopPropagation();

      this.classList.remove('bg-purple-900/30', 'ring-2', 'ring-purple-500');

      const taskId = e.dataTransfer.getData('taskId');
      const taskCard = document.querySelector(`.task-card[data-tache-id="${taskId}"]`);
      const newStatut = this.getAttribute('data-statut');

      if (taskCard) {
        // Ajouter l'animation de transition
        taskCard.style.opacity = '0.5';

        // Appel AJAX pour mettre à jour la base de données
        updateTaskStatus(taskId, newStatut, taskCard);
      }
    });
  });
}

/**
 * Met à jour le statut de la tâche via une requête AJAX
 * @param {number} taskId - ID de la tâche
 * @param {string} newStatut - Nouveau statut ('à faire', 'en cours', 'terminée')
 * @param {HTMLElement} taskCard - Élément DOM de la carte
 */
function updateTaskStatus(taskId, newStatut, taskCard) {
  // Récupérer l'ID du projet depuis l'URL ou un attribut
  const projectId = document.querySelector('[data-project-id]')?.getAttribute('data-project-id')
    || window.location.pathname.split('/').filter(p => p)[1];

  fetch(`/tache/${projectId}/${taskId}/status`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
    },
    body: JSON.stringify({
      statut: newStatut
    })
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`Erreur: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    if (data.success) {

        taskCard.style.opacity = '1';
      taskCard.classList.add('animate-pulse');

      setTimeout(() => {
        taskCard.classList.remove('animate-pulse');
      }, 1000);

      const targetColumn = document.querySelector(`[data-statut="${newStatut}"] .flex-1`);
      if (targetColumn) {
        targetColumn.appendChild(taskCard);
        updateColumnCounts();

      }
        const statutSpan = document.getElementById('modalStatut' + taskId);
        if (statutSpan) {
        let txt = '';
        let classes = '';
        if(newStatut === 'à faire') {
            txt = 'À faire';
            classes = 'bg-red-500/20 text-red-300 border border-red-500/30';
        }
        else if(newStatut === 'en cours') {
            txt = 'En cours';
            classes = 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30';
        }
        else {
            txt = 'Terminée';
            classes = 'bg-green-500/20 text-green-300 border border-green-500/30';
        }
        statutSpan.textContent = txt;
        statutSpan.className = 'px-3 py-1 text-xs font-semibold rounded ' + classes;
        }

    } else {
      throw new Error(data.message || 'Erreur lors de la mise à jour');
    }
  })
  .catch(error => {
    console.error('Erreur:', error);
    taskCard.style.opacity = '1';

    // Afficher une notification d'erreur
    showNotification('Erreur lors de la mise à jour du statut', 'error');
  });
}

/**
 * Met à jour les compteurs de tâches pour chaque colonne
 */
function updateColumnCounts() {
  const columns = document.querySelectorAll('[data-statut]');

  columns.forEach(column => {
    const taskCards = column.querySelectorAll('.task-card');
    const count = taskCards.length;
    const countSpan = column.querySelector('.text-sm.text-gray-500');

    if (countSpan) {
      countSpan.textContent = `(${count})`;
    }
  });
}

/**
 * Affiche une notification à l'utilisateur
 * @param {string} message - Message à afficher
 * @param {string} type - Type de notification ('success', 'error', 'info')
 */
function showNotification(message, type = 'info') {
  const notification = document.createElement('div');
  notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-[100] animate-slide-in ${
    type === 'success' ? 'bg-green-500' :
    type === 'error' ? 'bg-red-500' :
    'bg-blue-500'
  }`;
  notification.textContent = message;

  document.body.appendChild(notification);

  setTimeout(() => {
    notification.classList.add('animate-slide-out');
    setTimeout(() => notification.remove(), 300);
  }, 3000);
}

// Ajouter les animations CSS
const style = document.createElement('style');
style.textContent = `
  @keyframes slide-in {
    from {
      transform: translateX(400px);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  @keyframes slide-out {
    from {
      transform: translateX(0);
      opacity: 1;
    }
    to {
      transform: translateX(400px);
      opacity: 0;
    }
  }

  .animate-slide-in {
    animation: slide-in 0.3s ease-out;
  }

  .animate-slide-out {
    animation: slide-out 0.3s ease-out;
  }

  .task-card {
    cursor: grab;
    transition: all 0.2s ease;
  }

  .task-card:active {
    cursor: grabbing;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
  }

  [data-statut] {
    transition: all 0.2s ease;
  }
`;
document.head.appendChild(style);
</script>

<script>
document.getElementById('searchBtn').addEventListener('click', function() {
    document.getElementById('searchForm').submit();
});

@if(request('search'))
document.getElementById('resetBtn').addEventListener('click', function() {
    // Vider l’input recherche
    document.getElementById('searchInput').value = '';

    // Réinitialiser le select statut
    const selectStatut = document.querySelector('select[name="statut"]');
    if (selectStatut) {
        selectStatut.selectedIndex = 0; // Met sur "Tous Statuts"
    }

    // Envoyer le formulaire
    document.getElementById('searchForm').submit();
});
@endif

</script>
<script>
    window.membreRole = @json($membreRole);
</script>

@endpush

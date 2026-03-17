@extends('layouts.app')

@section('title', 'Tableau de bord - ' . $projet->nom . ' | Kollab')

@section('content')

<!-- En-tête -->
<header class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
  <div>
    <h1 class="text-2xl font-bold text-purple-400 tracking-tight">Tableau de bord du projet</h1>
    <p class="text-gray-400 text-sm">Vue d'ensemble du projet et de sa progression</p>
  </div>

  <div class="flex gap-4 flex-wrap items-center justify-center md:justify-end">
    <!-- Bouton Retour -->
    <a href="{{ route('projet.index') }}"
       class="group relative inline-flex items-center gap-2 bg-gray-900/60 text-gray-200 border border-gray-700 rounded-xl px-5 py-2.5 shadow-md backdrop-blur-md hover:bg-gray-800 hover:shadow-lg transition duration-300 ease-out">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-300 group-hover:-translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
      <span>Retour</span>
    </a>

    @php
      $isChef = Auth::id() === $projet->chef_id;
    @endphp
    @if($isChef)
      <div>
        @livewire('edit-projet-modal', ['projet' => $projet])
      </div>
    @endif
  </div>
</header>


<!-- Section principale -->
<section class="space-y-4 flex-1 px-4 md:px-10 w-full mx-auto max-w-5xl lg:max-w-[66vw]">

  @php
    $totalTaches = $projet->taches->count();
    $tachesTodo = $projet->taches->where('statut', 'à faire')->count();
    $tachesInProgress = $projet->taches->where('statut', 'en cours')->count();
    $tachesDone = $projet->taches->where('statut', 'terminée')->count();
    $progression = $totalTaches > 0 ? round(($tachesDone / $totalTaches) * 100) : 0;
  @endphp

<!-- En-tête projet & Statut -->
<div class="flex flex-col md:col-span-2 md:flex-row md:items-center md:justify-between gap-4 mb-3 bg-gradient-to-r from-gray-900 to-gray-800 border border-gray-700 rounded-xl p-5 backdrop-blur-sm">
  <div>
    <h1 class="text-1xl font-bold text-white">{{ $projet->nom }}</h1>
    <p class="text-gray-300 text-sm mt-1">{{ Str::limit($projet->description ?? '', 120) }}</p>
    <div class="flex gap-6 mt-2 text-xs text-gray-400">
    <div class="flex items-center gap-2 text-xs text-gray-300 mt-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    <span>
        Du {{ \Carbon\Carbon::parse($projet->date_debut)->format('d/m/Y à H:i') }}
        au {{ \Carbon\Carbon::parse($projet->date_fin_prevue)->format('d/m/Y à H:i') }}
    </span>
    </div>

    </div>
  </div>
    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-semibold
        @if($projet->statut == 'en attente') bg-yellow-900/40 text-yellow-300 border border-yellow-700/50
        @elseif($projet->statut == 'en cours') bg-green-900/40 text-green-300 border border-green-700/50
        @elseif($projet->statut == 'terminé') bg-gray-700/40 text-gray-300 border border-gray-600/50
        @endif">
        <span class="w-2 h-2 rounded-full animate-pulse
        @if($projet->statut == 'en attente') bg-yellow-400
        @elseif($projet->statut == 'en cours') bg-green-400
        @elseif($projet->statut == 'terminé') bg-gray-400
        @endif"></span>
        {{ ucfirst($projet->statut) }}
    </span>
</div>



  <!-- Grille principale : 2 colonnes stats / une navigation -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Colonne 1+2 (Statistiques des tâches et progression) -->
<div class="md:col-span-2">
  <div class="bg-gray-900/60 border border-gray-700 rounded-xl p-7">
    <h2 class="text-lg font-semibold text-gray-100 mb-1 flex items-center gap-2">
      Statistiques des tâches
    </h2>
    <div class="flex flex-col md:flex-row md:items-center md:gap-8">
      <!-- Progression : colonne gauche bien centrée -->
      <div class="flex flex-col items-center justify-center md:w-[180px] w-full mr-8">
        <span class="text-base font-semibold text-gray-100 mb-4">Progression globale</span>
        <div class="relative w-[110px] h-[110px] flex items-center justify-center mb-2">
          @php
            $radius = 42;
            $circ = 2 * 3.14 * $radius;
            $offset = $circ * (1 - $progression / 100);
          @endphp
          <svg width="110" height="110" class="absolute top-0 left-0">
            <circle r="{{ $radius }}" cx="55" cy="55" fill="transparent" stroke="#25283D" stroke-width="14"/>
            <circle r="{{ $radius }}" cx="55" cy="55" fill="transparent"
              stroke="url(#progressGradient)" stroke-width="14"
              stroke-dasharray="{{ $circ }}"
              stroke-dashoffset="{{ $offset }}"
              stroke-linecap="round"/>
            <defs>
              <linearGradient id="progressGradient" x1="0" x2="1" y1="0" y2="1">
                <stop offset="5%" stop-color="#8b5cf6"/>
                <stop offset="90%" stop-color="#06b6d4"/>
              </linearGradient>
            </defs>
          </svg>
          <span class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-white">{{ $progression }}%</span>
        </div>
        <div class="text-gray-400 text-xs mt-2">{{ $tachesDone }} sur {{ $totalTaches }} tâches complétées</div>
      </div>
      <!-- Stats barres -->
      <div class="flex-1 space-y-4 md:pt-0">
        <div>
          <div class="flex items-center justify-between mb-1">
            <span class="text-sm font-medium text-gray-300">Total des tâches</span>
            <span class="text-2xl font-bold text-purple-400">{{ $totalTaches }}</span>
          </div>
          <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-blue-600 to-indigo-400 rounded-full" style="width: 100%"></div>
          </div>
        </div>
        <div class="flex items-center justify-between mb-1">
            <span class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="text-sm font-medium text-gray-300">En retard</span>
            </span>
            <span class="text-xl font-bold text-red-500 flex items-center">
                {{ $tachesLate }}
            </span>
        </div>
        <div>
          <div class="flex items-center justify-between mb-1">
            <span class="flex items-center gap-2">
              <span class="w-3 h-3 rounded-full bg-orange-500"></span>
              <span class="text-sm font-medium text-gray-300">À faire</span>
            </span>
            <span class="text-xl font-bold text-orange-400 flex items-center">
              {{ $tachesTodo }} <span class="text-sm text-gray-400 ml-2">({{ $totalTaches > 0 ? round(($tachesTodo / $totalTaches) * 100) : 0 }}%)</span>
            </span>
          </div>
          <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-orange-600 to-orange-400 rounded-full transition-all duration-500"
                 style="width: {{ $totalTaches > 0 ? ($tachesTodo / $totalTaches) * 100 : 0 }}%"></div>
          </div>
        </div>
        <div>
          <div class="flex items-center justify-between mb-1">
            <span class="flex items-center gap-2">
              <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
              <span class="text-sm font-medium text-gray-300">En cours</span>
            </span>
            <span class="text-xl font-bold text-yellow-400 flex items-center">
              {{ $tachesInProgress }} <span class="text-sm text-gray-400 ml-2">({{ $totalTaches > 0 ? round(($tachesInProgress / $totalTaches) * 100) : 0 }}%)</span>
            </span>
          </div>
          <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-yellow-600 to-yellow-400 rounded-full transition-all duration-500"
                 style="width: {{ $totalTaches > 0 ? ($tachesInProgress / $totalTaches) * 100 : 0 }}%"></div>
          </div>
        </div>
        <div>
          <div class="flex items-center justify-between mb-1">
            <span class="flex items-center gap-2">
              <span class="w-3 h-3 rounded-full bg-green-500"></span>
              <span class="text-sm font-medium text-gray-300">Terminées</span>
            </span>
            <span class="text-xl font-bold text-green-400 flex items-center">
              {{ $tachesDone }} <span class="text-sm text-gray-400 ml-2">({{ $progression }}%)</span>
            </span>
          </div>
          <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-green-600 to-green-400 rounded-full transition-all duration-500"
                 style="width: {{ $progression }}%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- Colonne 3 (Navigation + membres) -->
    <div class="space-y-2 flex flex-col gap-2">
      <!-- Kanban -->
      <a href="{{ route('tache.index', $projet->id_projet) }}"
        class="group bg-gray-900/60 border border-gray-700 hover:border-blue-600 rounded-xl p-4 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/50 flex items-center gap-3">
        <div class="bg-blue-900/40 p-3 rounded-lg group-hover:scale-110 transition-transform">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
        </div>
        <div class="flex-1">
          <h3 class="text-base font-bold text-gray-100 group-hover:text-blue-300 transition">Kanban</h3>
          <p class="text-xs text-gray-400">Gérez vos tâches</p>
        </div>
      </a>

      <!-- Roadmap -->
      <a href="{{ route('projet.sprints.index', $projet->id_projet) }}"
        class="group bg-gray-900/60 border border-gray-700 hover:border-green-600 rounded-xl p-4 transition-all duration-300 hover:shadow-lg hover:shadow-green-900/50 flex items-center gap-3">
        <div class="bg-green-900/40 p-3 rounded-lg group-hover:scale-110 transition-transform">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
        </div>
        <div class="flex-1">
          <h3 class="text-base font-bold text-gray-100 group-hover:text-green-300 transition">Roadmap</h3>
          <p class="text-xs text-gray-400">Planning des sprints</p>
        </div>
      </a>
          <!-- Bloc nombre de membres -->
            <div class="bg-gray-900/60 border border-gray-700 rounded-xl p-5 py-9 flex flex-col items-center justify-center">
                <span class="text-4xl font-bold text-purple-400">{{ $projet->membres->count() }}</span>
                <span class="text-lg text-gray-300 mt-2">
                    {{ $projet->membres->count() <= 1 ? 'Membre' : 'Membres' }}
                </span>
            </div>
    </div>
  </div>

    <div class="grid grid-cols-3 gap-8 my-8">
    @if($isChef)
        <!-- Bloc ajout membre : 1/3 -->
        <div class="col-span-1 flex flex-col h-full gap-3">
            <div class="bg-gray-900/60 border border-gray-700 rounded-xl p-6 shadow-xl h-full flex flex-col justify-between">
                <div>
                    <h4 class="text-base font-bold text-purple-300 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter un membre
                    </h4>
                    <form action="{{ route('membre.ajouter', ['projet' => $projet->id_projet]) }}" method="POST" class="flex flex-col gap-3">
                        @csrf
                            <div class="relative">
                                <input type="text" id="user-search" placeholder="Email ou nom de l'utilisateur"
                                    class="w-full px-4 py-2 rounded-lg bg-gray-800 text-gray-100 border border-gray-700 focus:ring focus:ring-purple-600 text-sm" autocomplete="off"/>
                                <input type="hidden" name="user_id" id="user-id">

                                <ul id="suggestions"
                                    class="absolute left-0 right-0 mt-1 hidden rounded-lg border border-gray-700 bg-gray-900/95 backdrop-blur-sm shadow-lg z-50 overflow-hidden text-sm">
                                </ul>
                            </div>
                        <select name="role" required
                            class="px-4 py-2 rounded-lg bg-gray-800 text-gray-100 border border-gray-700 focus:ring focus:ring-purple-600">
                            <option value="">- Sélectionner le rôle -</option>
                            <option value="editeur">Éditeur</option>
                            <option value="lecteur">Lecteur</option>
                        </select>
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-semibold px-6 py-2 rounded-lg shadow hover:scale-[1.04] transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:rotate-6 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Ajouter</span>
                        </button>
                    </form>
                </div>
                @if(session('error'))
                    <div class="mt-3 rounded bg-red-900/80 text-red-300 px-3 py-2 text-sm shadow">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        <!-- Bloc membres projet : 2/3 -->
        <div class="col-span-2 flex flex-col h-full">
            <div class="bg-gray-900/70 border border-gray-700 rounded-xl p-5 shadow-lg h-full flex flex-col">
                <div class="flex items-center justify-between mb-4 gap-2">
                    <h3 class="text-base font-bold text-purple-300 flex items-center gap-2 m-0">
                        Membres du projet
                    </h3>
                    @if(session('success'))
                        <div class="rounded-full bg-green-900/80 text-green-300 px-4 py-1 text-sm shadow text-right whitespace-nowrap transition-all duration-200">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                @php
                    $chef = $projet->membres->firstWhere('id_utilisateur', $projet->chef_id);
                    $autres = $projet->membres->where('id_utilisateur', '!=', $projet->chef_id);
                @endphp
                @if($chef)
                    <div class="flex items-center gap-2 mb-2 border-b border-gray-800 pb-3">
                        <span class="truncate text-gray-100 font-medium text-base">
                            {{ $chef->user->name ?? $chef->name }}
                        </span>
                        <span class="ml-2 px-2 py-0.5 rounded-full bg-violet-700/80 text-[11px] font-bold text-white">Chef du projet</span>
                    </div>
                @endif
                <div class="flex flex-wrap gap-2 mt-2">
                    @forelse($autres as $membre)
                        <div class="flex items-center px-3 py-1.5 bg-gray-800 rounded-full shadow border border-gray-700 text-gray-100 text-sm font-medium group relative">
                            <span class="truncate max-w-[110px] pl-2">{{ $membre->user->name ?? $membre->name }}</span>
                            <form action="{{ route('membre.retirer', [
                                'projet' => $projet->id_projet,
                                'membre' => $membre->id_utilisateur
                            ]) }}"
                                method="POST"
                                onsubmit="return confirm('Retirer ce membre du projet ?');"
                                class="ml-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="ml-1 rounded-full hover:bg-rose-800/80 transition h-6 w-6 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-rose-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                            <div x-data="{ open: false }" class="relative ml-1">
                                <button type="button" @click="open = !open" class="rounded-full hover:bg-blue-800/70 p-1 flex items-center justify-center transition">
                                    <svg class="w-4 h-4 text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                    </svg>
                                </button>
                                <div
                                    x-show="open"
                                    @click.away="open = false"
                                    class="absolute z-40 right-0 mt-1 w-36 bg-gray-900 border border-gray-700 rounded shadow-xl"
                                    style="display: none;">
                                    <form action="{{ route('membre.role', ['projet' => $projet->id_projet, 'membre' => $membre->id_utilisateur]) }}" method="POST" class="flex flex-col p-2 gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="role" value="editeur"
                                            @if($membre->role == 'editeur') disabled class="text-green-400 font-bold text-left py-1 px-2 rounded bg-gray-800" @else class="text-gray-300 hover:bg-gray-800 py-1 px-2 rounded text-left" @endif>
                                            @if($membre->role == 'editeur') ✔ @endif Éditeur
                                        </button>
                                        <button type="submit" name="role" value="lecteur"
                                            @if($membre->role == 'lecteur') disabled class="text-green-400 font-bold text-left py-1 px-2 rounded bg-gray-800" @else class="text-gray-300 hover:bg-gray-800 py-1 px-2 rounded text-left" @endif>
                                            @if($membre->role == 'lecteur') ✔ @endif Lecteur
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <span class="text-gray-400 text-sm">Aucun autre membre pour le moment</span>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        <!-- Bloc membres projet : 3/3 plein écran -->
        <div class="col-span-3 flex flex-col h-full">
            <div class="bg-gray-900/70 border border-gray-700 rounded-xl p-5 shadow-lg h-full flex flex-col">
                <div class="flex items-center justify-between mb-4 gap-2">
                    <h3 class="text-base font-bold text-purple-300 flex items-center gap-2 m-0">
                        Membres du projet
                    </h3>
                    @if(session('success'))
                        <div class="rounded-full bg-green-900/80 text-green-300 px-4 py-1 text-sm shadow text-right whitespace-nowrap transition-all duration-200">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                @php
                    $chef = $projet->membres->firstWhere('id_utilisateur', $projet->chef_id);
                    $autres = $projet->membres->where('id_utilisateur', '!=', $projet->chef_id);
                @endphp
                @if($chef)
                    <div class="flex items-center gap-2 mb-2 border-b border-gray-800 pb-3">
                        <span class="truncate text-gray-100 font-medium text-base">
                            {{ $chef->user->name ?? $chef->name }}
                        </span>
                        <span class="ml-2 px-2 py-0.5 rounded-full bg-violet-700/80 text-[11px] font-bold text-white">Chef du projet</span>
                    </div>
                @endif
                <div class="flex flex-wrap gap-2 mt-2">
                    @forelse($autres as $membre)
                        <div class="flex items-center px-3 py-1.5 bg-gray-800 rounded-full shadow border border-gray-700 text-gray-100 text-sm font-medium group relative">
                            <span class="pl-2">
                                {{ $membre->user->name ?? $membre->name }}
                            </span>
                            @if($membre->role == 'editeur')
                                <span class="ml-2 px-2 py-0.5 rounded-full bg-green-700/70 text-xs font-semibold text-green-100">
                                    Éditeur
                                </span>
                            @elseif($membre->role == 'lecteur')
                                <span class="ml-2 px-2 py-0.5 rounded-full bg-blue-700/70 text-xs font-semibold text-blue-100">
                                    Lecteur
                                </span>
                            @endif
                        </div>
                    @empty
                        <span class="text-gray-400 text-sm">Aucun autre membre pour le moment</span>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <!-- Graphe d'avancement (2/3) -->
        <div class="md:col-span-2 bg-gray-900/80 border border-gray-700 rounded-xl p-4 shadow-lg flex flex-col items-center">
            <h4 class="text-base font-bold text-purple-300 mb-3">Courbe d’avancement</h4>
            <canvas id="progressChart" style="width:100%;max-width:100%;height:200px;max-height:220px;"></canvas>
        </div>
        <!-- Diagramme en secteurs (1/3) -->
        <div class="md:col-span-1 bg-gray-900/80 border border-gray-700 rounded-xl p-4 shadow-lg flex flex-col items-center">
            <h4 class="text-base font-bold text-purple-300 mb-3">Répartition des tâches</h4>
            <canvas id="tasksPieChart" style="width:100%;max-width:260px;height:160px;max-height:180px;"></canvas>
        </div>
    </div>

</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.addEventListener('projetUpdated', () => {
        window.location.reload();
    });
</script>

<script>
    const total = {{ $totalTaches }};
    const aFaire = {{ $tachesTodo }};
    const enCours = {{ $tachesInProgress }};
    const terminees = {{ $tachesDone }};
    const enRetard = {{ $tachesLate }};


    const avancementLabels = @json($courbe_labels);
    const tachesCompletesParSemaine = @json($courbe_cumul);

    // Graphe
    new Chart(document.getElementById('progressChart'), {
        type: 'line',
        data: {
            labels: avancementLabels,
            datasets: [{
                label: 'Tâches terminées (cumulées chaque semaine)',
                data: tachesCompletesParSemaine,
                fill: true,
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.10)',
                tension: 0.3
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: '#fff' } }
            },
            scales: {
                x: { ticks: { color: '#c4b5fd' } },
                y: { beginAtZero: true, ticks: { color: '#d1fae5' } }
            }
        }
    });

    // Diagramme
    new Chart(document.getElementById('tasksPieChart'), {
        type: 'pie',
        data: {
            labels: ['En retard','À faire', 'En cours', 'Terminée'],
            datasets: [{
                data: [enRetard, aFaire, enCours, terminees],
                backgroundColor: ['#cf3711ff','#283ba3ff', '#67c2f7ff', '#7021b9ff'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: '#fff' } }
            }
        }
    });
</script>

<script>
const input = document.getElementById('user-search');
const suggestions = document.getElementById('suggestions');
const hiddenInput = document.getElementById('user-id');
const projetId = {{ $projet->id_projet }};
let timeout = null;

input.addEventListener('input', () => {
    clearTimeout(timeout);
    const query = input.value.trim();

    if (query.length < 2) {
        suggestions.innerHTML = '';
        suggestions.classList.add('hidden');
        return;
    }

    timeout = setTimeout(() => {
        fetch(`{{ route('users.search') }}?q=${encodeURIComponent(query)}&projet_id=${projetId}`)
            .then(res => res.json())
            .then(users => {
                suggestions.innerHTML = '';
                if (users.length === 0) {
                    suggestions.innerHTML = '<li class="px-4 py-2 text-gray-400">Aucun résultat</li>';
                    suggestions.classList.remove('hidden');
                    return;
                }

                users.forEach(user => {
                    const li = document.createElement('li');
                    li.classList.add(
                        'px-4', 'py-2', 'hover:bg-gray-700', 'cursor-pointer',
                        'transition', 'duration-150', 'text-gray-200'
                    );
                    li.textContent = `${user.name} (${user.email})`;
                    li.addEventListener('click', () => {
                        input.value = user.email;
                        hiddenInput.value = user.id;
                        suggestions.classList.add('hidden');
                    });
                    suggestions.appendChild(li);
                });


                suggestions.classList.remove('hidden');
            });
    }, 300);
});

document.addEventListener('click', (e) => {
    if (!suggestions.contains(e.target) && e.target !== input) {
        suggestions.classList.add('hidden');
    }
});
</script>

@endsection

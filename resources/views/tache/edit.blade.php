@extends('layouts.app')

@section('title', 'Modifier - ' . $tache->titre . ' | Kollab')

@section('content')
<div class="max-w-3xl mx-auto bg-gray-800 rounded-xl shadow-lg px-7 py-7 mt-4">
  <h1 class="text-xl font-semibold text-purple-400 mb-8 flex items-center gap-2">
    Modifier la tâche
  </h1>
  <form action="{{ route('tache.update', [$projet->id_projet, $tache->id_tache]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-8 relative">
      <!-- Colonne 1 : descriptif + epic -->
      <div class="pb-1">
        <!-- Titre -->
        <div class="mb-4">
          <label for="titre" class="block text-md text-gray-300">Titre de la tâche</label>
          <input type="text" id="titre" name="titre"
            class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100
              text-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition"
            maxlength="50" required value="{{ old('titre', $tache->titre) }}">
        </div>
        <!-- Description -->
        <div class="mb-4">
          <label for="description" class="block text-md text-gray-300">Description</label>
          <textarea id="description" name="description"
            class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100
              text-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition resize-none"
            maxlength="100" placeholder="Détails de la tâche...">{{ old('description', $tache->description) }}</textarea>
        </div>
        <!-- Epic -->
        <div class="mb-4">
          <label for="id_epic" class="block text-md text-gray-300">Epic associé</label>
          <select id="id_epic" name="id_epic" required
            class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100
              text-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition">
            <option value="">-- Aucun epic --</option>
            @foreach ($epics as $epic)
              <option value="{{ $epic->id_epic }}"
                {{ old('id_epic', $tache->id_epic) == $epic->id_epic ? 'selected' : '' }}>
                {{ $epic->titre }}
              </option>
            @endforeach
          </select>
        </div>
                <!-- Statut -->
        <div class="mb-4">
          <label for="statut" class="block text-md text-gray-300">Statut</label>
          <select id="statut" name="statut"
            class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100
              text-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition" required>
            <option value="à faire" {{ old('statut', $tache->statut) == 'à faire' ? 'selected' : '' }}>À faire</option>
            <option value="en cours" {{ old('statut', $tache->statut) == 'en cours' ? 'selected' : '' }}>En cours</option>
            <option value="terminée" {{ old('statut', $tache->statut) == 'terminée' ? 'selected' : '' }}>Terminée</option>
          </select>
        </div>
      </div>

      <!-- Séparateur vertical desktop -->
      <div class="hidden md:block absolute left-1/2 top-4 bottom-4 w-px bg-gray-700"></div>

      <!-- Colonne 2 : organisation + dates -->
      <div class="pt-1">
        <!-- Date de début -->
        <div class="mb-4">
          <label for="date_debut" class="block text-md text-gray-300">Date de début</label>
          <input type="datetime-local" id="date_debut" name="date_debut"
            class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100
              text-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition"
            value="{{ old('date_debut', isset($tache) && $tache->date_debut ? $tache->date_debut->format('Y-m-d\TH:i') : '') }}">
        </div>
        <!-- Date de fin prévue -->
        <div class="mb-4">
          <label for="date_fin_prevue" class="block text-md text-gray-300">Date de fin prévue</label>
          <input type="datetime-local" id="date_fin_prevue" name="date_fin_prevue"
            class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100
              text-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition"
            value="{{ old('date_fin_prevue', isset($tache) && $tache->date_fin_prevue ? $tache->date_fin_prevue->format('Y-m-d\TH:i') : '') }}">
        </div>
        <!-- Priorité -->
        <div class="mb-4">
          <label for="priorite" class="block text-md text-gray-300">Priorité</label>
          <select id="priorite" name="priorite"
            class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100
              text-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition" required>
            <option value="basse" {{ old('priorite', $tache->priorite) == 'basse' ? 'selected' : '' }}>Basse</option>
            <option value="moyenne" {{ old('priorite', $tache->priorite) == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
            <option value="haute" {{ old('priorite', $tache->priorite) == 'haute' ? 'selected' : '' }}>Haute</option>
          </select>
        </div>

        @auth
          @if(Auth::id() === $projet->chef_id)
          <div class="mb-4">
            <label for="id_utilisateur" class="block text-md text-gray-300">Assigner à</label>
            <select id="id_utilisateur" name="id_utilisateur"
              class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100
                text-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition">
              <option value="">Aucun membre</option>
              @foreach ($utilisateurs as $membre)
                <option value="{{ $membre->id }}" @if($tache->id_utilisateur == $membre->id) selected @endif>
                  {{ $membre->name }} ({{ ucfirst($membre->role) }})
                </option>
              @endforeach
            </select>
          </div>
          @endif
        @endauth
      </div>
    </div>

    <!-- Boutons centrés -->
    <div class="flex gap-4 justify-between mt-8">
      <a href="{{ route('tache.index', $projet->id_projet) }}"
        class="group relative inline-flex items-center gap-2 bg-gray-900/60 text-gray-200 border border-gray-700 rounded-xl px-5 py-2.5 shadow-md backdrop-blur-md hover:bg-gray-800 hover:shadow-lg transition duration-300 ease-out text-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-300 group-hover:-translate-x-1 transition"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Annuler
      </a>
      <button type="submit"
        class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-6 py-2.5 rounded-xl shadow-lg transition duration-300 ease-in-out hover:scale-105 text-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:rotate-12 transition-transform"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Modifier
      </button>
    </div>
  </form>
</div>
@endsection

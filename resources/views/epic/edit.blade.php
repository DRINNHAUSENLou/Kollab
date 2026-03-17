@extends('layouts.app')

@section('title', 'Modifier - ' . $epic->titre . ' | Kollab')

@section('content')
<div class="max-w-xl mx-auto bg-gray-800 rounded-xl shadow-lg px-7 py-7 mt-8">
  <h1 class="text-xl font-semibold text-purple-400 mb-5 flex items-center gap-2">
    Modifier l'Epic : <strong class="text-purple-300">{{ $epic->titre }}</strong>
  </h1>
  <form method="POST" action="{{ route('epic.update', [$projet->id_projet, $epic->id_epic]) }}">
    @csrf
    @method('PUT')

    @if(request()->has('sprint_id'))
      <input type="hidden" name="sprint_id" value="{{ request()->get('sprint_id') }}">
    @endif
    <input type="hidden" name="statut" value="{{ $epic->statut }}">

    <!-- Titre -->
    <div class="mb-4">
      <label for="titre" class="block text-md text-gray-300">Titre de l'epic</label>
      <input type="text" id="titre" name="titre"
        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 text-md
              focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition"
        maxlength="50" required value="{{ old('titre', $epic->titre) }}">
      @error('titre')
        <small class="text-red-500">{{ $message }}</small>
      @enderror
    </div>

    <!-- Description -->
    <div class="mb-4">
      <label for="description" class="block text-md text-gray-300">Description (facultatif)</label>
      <textarea id="description" name="description"
        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 text-md
              focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition resize-none"
        maxlength="100" placeholder="Description de l'epic...">{{ old('description', $epic->description) }}</textarea>
      @error('description')
        <small class="text-red-500">{{ $message }}</small>
      @enderror
    </div>

    <!-- Priorité -->
    <div class="mb-5">
      <label for="priorite" class="block text-md text-gray-300">Priorité</label>
      <select id="priorite" name="priorite"
        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 text-md
             focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition" required>
        <option value="basse" {{ old('priorite', $epic->priorite) === 'basse' ? 'selected' : '' }}>Basse</option>
        <option value="moyenne" {{ old('priorite', $epic->priorite) === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
        <option value="haute" {{ old('priorite', $epic->priorite) === 'haute' ? 'selected' : '' }}>Haute</option>
      </select>
      @error('priorite')
        <small class="text-red-500">{{ $message }}</small>
      @enderror
    </div>

    <!-- Boutons d'action -->
    <div class="flex gap-4 justify-between mt-7">
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

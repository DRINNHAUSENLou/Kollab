@extends('layouts.app')

@section('title', 'Créer un epic | Kollab')

@section('content')
<div class="max-w-xl mx-auto bg-gray-800 rounded-xl shadow-lg px-7 py-7 mt-8">
  <h1 class="text-xl font-semibold text-purple-400 mb-5 flex items-center gap-2">
    Ajouter un Epic au projet : <strong class="text-purple-300">{{ $projet->nom }}</strong>
  </h1>
  <form method="POST" action="{{ route('epic.store', $projet->id_projet) }}">
    @csrf
    @if(isset($sprintActuelId))
      <input type="hidden" name="sprint_id" value="{{ $sprintActuelId }}">
    @endif
    <!-- Titre -->
    <div class="mb-4">
      <label for="titre" class="block text-md text-gray-300">Titre</label>
      <input type="text" id="titre" name="titre"
        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 text-md
              focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition"
        maxlength="50" required value="{{ old('titre') }}">
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
        maxlength="100">{{ old('description') }}</textarea>
    </div>
    <!-- Priorité -->
    <div class="mb-5">
      <label for="priorite" class="block text-md text-gray-300">Priorité</label>
      <select id="priorite" name="priorite"
        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 text-md
             focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition">
        <option value="basse">Basse</option>
        <option value="moyenne" selected>Moyenne</option>
        <option value="haute">Haute</option>
      </select>
    </div>
    <!-- Boutons -->
    <div class="flex gap-4 justify-between mt-7">
      <a href="{{ route('tache.index', ['id_projet' => $projet->id_projet, 'sprint_id' => $sprintActuelId ?? null]) }}"
        class="group relative inline-flex items-center gap-2 bg-gray-900/60 text-gray-200 border border-gray-700 rounded-xl px-5 py-2.5 shadow-md backdrop-blur-md hover:bg-gray-800 hover:shadow-lg transition duration-300 ease-out text-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-300 group-hover:-translate-x-1 transition"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Retour
      </a>
      <button type="submit"
        class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-6 py-2.5 rounded-xl shadow-lg transition duration-300 ease-in-out hover:scale-105 text-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:rotate-12 transition-transform"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Créer
      </button>
    </div>
  </form>
</div>

@if(session('success'))
@push('scripts')
<script>
  alert('Epic créé avec succès !');
  window.location.href = '{{ route("tache.index", ["id_projet" => $projet->id_projet, "sprint_id" => $sprintActuelId ?? null]) }}';
</script>
@endpush
@endif

@endsection

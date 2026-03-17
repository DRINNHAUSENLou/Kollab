@extends('layouts.app')

@section('title', 'Créer un sprint | Kollab')

@section('content')
<div class="max-w-xl mx-auto bg-gray-800 rounded-xl shadow-lg px-7 py-7 mt-8">
  <h1 class="text-xl font-semibold text-purple-400 mb-5 flex items-center gap-2">
    Créer un sprint
  </h1>
  <form method="POST" action="{{ route('projet.sprints.store', $projet->id_projet) }}">
    @csrf
    <!-- Nom du sprint -->
    <div class="mb-4">
      <label for="nom" class="block text-md text-gray-300">Nom du sprint</label>
      <input type="text" id="nom" name="nom"
        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 text-md
              focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition"
        maxlength="50" required>
    </div>
    <!-- ID projet (caché) -->
    <input type="hidden" name="id_projet" value="{{ $projet->id_projet }}">

    <!-- Dates -->
    <div class="mb-4 flex flex-col md:flex-row md:gap-4">
      <div class="flex-1">
        <label for="date_debut" class="block text-md text-gray-300">Date de début</label>
        <input type="datetime-local" id="date_debut" name="date_debut"
          class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 text-md
                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition"
          required>
      </div>
      <div class="flex-1 mt-4 md:mt-0">
        <label for="date_fin" class="block text-md text-gray-300">Date de fin prévue</label>
        <input type="datetime-local" id="date_fin" name="date_fin"
           class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 text-md
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition"
           required>
      </div>
    </div>
    <!-- Objectif -->
    <div class="mb-5">
      <label for="objectif" class="block text-md text-gray-300">Objectif</label>
      <textarea id="objectif" name="objectif"
        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 text-md
              focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-600 transition resize-none"
        maxlength="100"></textarea>
    </div>
    <!-- Boutons -->
    <div class="flex gap-4 justify-between mt-7">
      <a href="{{ route('projet.sprints.index', $projet->id_projet) }}"
        class="group relative inline-flex items-center gap-2 bg-gray-900/60 text-gray-200 border border-gray-700 rounded-xl px-5 py-2.5 shadow-md backdrop-blur-md hover:bg-gray-800 hover:shadow-lg transition duration-300 ease-out text-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-300 group-hover:-translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Retour
      </a>
      <button type="submit"
        class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-6 py-2.5 rounded-xl shadow-lg transition duration-300 ease-in-out hover:scale-105 text-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
  alert('Sprint créé avec succès !');
  window.location.href = '{{ route("projet.sprints.index", $projet->id_projet) }}';
</script>
@endpush
@endif

@endsection

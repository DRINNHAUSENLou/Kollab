<div>
    <!-- Liste sprints, affichage en lignes -->
    <div class="flex flex-col gap-5">
        <h2 class="text-1xl font-semibold text-purple-400">Liste des sprints</h2>
        @foreach($sprints as $sprint)
            <div class="bg-gray-900/80 border border-gray-700 rounded-xl p-4 flex items-center justify-between min-w-0">
                <span class="text-base font-semibold text-purple-100 break-words max-w-full">{{ $sprint->nom }}</span>
                @auth
                    @if(Auth::id() === $projet->chef_id)
                        <button wire:click="editSprint({{ $sprint->id_sprint }})"
                            class="ml-3 bg-gradient-to-r from-blue-600 to-purple-700 font-semibold hover:shadow-2xl hover:scale-[1.03] text-sm px-4 py-2 rounded-xl transition whitespace-nowrap">
                            Modifier
                        </button>
                    @endif
                @endauth
            </div>
        @endforeach
    </div>

    <!-- Modal de modification -->
@if($editingSprint)
    <div
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        tabindex="0"
        wire:keydown.escape.window="closeModal"
    >
        <div class="absolute inset-0" wire:click="closeModal"></div>
        <div class="relative z-10 bg-gray-800 rounded-lg shadow-lg p-10 w-full max-w-2xl border border-gray-700">
            <button wire:click="closeModal"
                class="absolute top-3 right-3 text-gray-400 hover:text-white text-3xl w-12 h-12 flex items-center justify-center rounded-full transition p-0">
                &times;
            </button>
            <h2 class="text-2xl font-semibold text-purple-400 mb-6">Modifier le sprint : {{ $form['nom'] }}</h2>
            <form wire:submit.prevent="saveSprint">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300">Nom</label>
                    <input type="text" wire:model.defer="form.nom"
                        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300">Date de début</label>
                    <input type="date" wire:model.defer="form.date_debut"
                        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300">Date de fin</label>
                    <input type="date" wire:model.defer="form.date_fin"
                        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300">Objectif</label>
                    <textarea wire:model.defer="form.objectif" rows="3"
                        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100"></textarea>
                </div>
<div class="flex justify-between items-center mt-8 flex-wrap gap-2">
    <button type="button" wire:click="closeModal"
        class="inline-flex items-center gap-2 bg-gray-800 text-gray-200 border border-gray-700 rounded-lg px-5 py-2 text-base shadow hover:bg-gray-700 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Annuler
    </button>
    <div class="flex gap-2">
        @if(!$confirmDelete)
            <button type="button" wire:click="askDelete"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-pink-700 text-white font-medium px-5 py-2 rounded-lg text-base shadow hover:scale-105 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Supprimer
            </button>
        @else
            <div class="flex gap-2">
                <span class="text-red-300 self-center">Êtes-vous sûr&nbsp;?</span>
                <button type="button" wire:click="deleteSprint"
                    class="inline-flex items-center gap-2 bg-red-700 text-white font-medium px-3 py-2 rounded-lg text-base shadow hover:bg-red-800 transition">
                    Oui
                </button>
                <button type="button" wire:click="cancelDelete"
                    class="inline-flex items-center gap-1 bg-gray-700 text-gray-200 border border-gray-500 rounded-lg px-2 py-2 shadow text-base hover:bg-gray-600">
                    Non
                </button>
            </div>
        @endif
        <button type="submit"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white px-6 py-2 rounded-lg shadow hover:scale-105 transition">
            Enregistrer
        </button>
    </div>
</div>

            </form>
        </div>
    </div>
@endif


</div>

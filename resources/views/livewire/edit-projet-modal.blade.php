    <!-- Pop up -->
    <div x-data="{ showModal: @entangle('showModal') }">
    <!-- Bouton ouverture pop up -->
    <button @click="showModal = true"
        class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-lg transition duration-300 ease-in-out">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        <span>Modifier</span>
    </button>

    <!-- Pop up -->
    <div x-show="showModal"
            x-trap="showModal"
            x-on:keydown.escape.window=" showModal = false;
                $wire.closeModal();"
            x-on:click.self="showModal = false;
                $wire.closeModal();"
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50"
         style="display:none" tabindex="0">
        <div class="bg-gray-800 rounded-lg shadow-lg max-w-xl w-full p-8 relative"
             @click.stop>
            <!-- BOUTON CROIX DE FERMETURE DANS COIN HAUT DROIT -->
            <button @click="showModal = false; $wire.closeModal();"
                class="absolute top-3 right-3 text-gray-400 hover:text-white text-3xl w-12 h-12 flex items-center justify-center rounded-full transition p-0">
                &times;
            </button>
            <h1 class="text-2xl font-semibold text-purple-400 mb-6">Modifier le projet</h1>
            <form wire:submit.prevent="save">
                <!-- Nom -->
                <div class="mb-4">
                    <label for="nom" class="block text-sm text-gray-300">Nom du projet</label>
                    <input type="text" id="nom" wire:model="nom" maxlength="50"
                        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100" required>
                </div>
                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm text-gray-300">Description</label>
                    <textarea id="description" wire:model="description" maxlength="100"
                        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100"></textarea>
                </div>
                <!-- Dates -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-300">Date de début</label>
                    <input type="datetime-local" wire:model="date_debut"
                        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100">
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-300">Date de fin prévue</label>
                    <input type="datetime-local" wire:model="date_fin_prevue"
                        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100">
                </div>
                <!-- Priorité -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-300">Priorité</label>
                    <select wire:model="priorite"
                        class="w-full mt-2 px-4 py-2 rounded-md bg-gray-700 border border-gray-600 text-gray-100" required>
                        <option value="basse">Basse</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="haute">Haute</option>
                    </select>
                </div>
                <!-- Boutons -->
                <div class="flex gap-4 justify-between mt-6">
                    <button type="button" @click="showModal = false; $wire.closeModal();"
                        class="group relative inline-flex items-center gap-2 bg-gray-900/60 text-gray-200 border border-gray-700 rounded-xl px-5 py-2.5 shadow-md backdrop-blur-md hover:bg-gray-800 hover:shadow-lg transition duration-300 ease-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-300 group-hover:-translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Annuler
                    </button>
                    <div class="flex gap-3">
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
                                <button type="button" wire:click="deleteProjet"
                                    class="inline-flex items-center gap-2 bg-red-700 text-white font-medium px-3 py-2 rounded-lg text-base shadow hover:bg-red-800 transition">
                                    Oui
                                </button>
                                <button type="button" wire:click="cancelDelete"
                                    class="inline-flex items-center gap-1 bg-gray-700 text-gray-200 border border-gray-500 rounded-lg px-2 py-2 shadow text-base hover:bg-gray-600 ">
                                    Non
                                </button>
                            </div>
                        @endif

                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-6 py-2.5 rounded-xl hover:scale-105 transition-all duration-200">Enregistrer</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

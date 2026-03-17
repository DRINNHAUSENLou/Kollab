<div><!-- Header centré, toujours au-dessus -->
<div class="mb-10 text-center text-gray-200">
    <h1 class="text-3xl font-semibold mb-2">
        Bonjour, {{ $form['name'] ?? Auth::user()->name }} !
    </h1>
    <p class="text-md opacity-70">
        Personnalise ton profil pour être plus reconnaissable sur Kollab.<br>
        Choisis la couleur qui te ressemble, et mets à jour tes informations personnelles.
    </p>
</div>

<!-- Conteneur flex : responsive -->
<div class="flex flex-col md:flex-row md:items-start md:justify-center gap-10 w-full">

    <!-- Bloc profil : prend toute la largeur sur mobile, max sur desktop -->
    <div class="w-full md:flex-1 max-w-2xl bg-gray-900 rounded-2xl shadow-2xl p-8 mb-8 md:mb-0">

        @if(session()->has('success'))
            <div class="mb-6 text-green-400 font-bold text-lg">{{ session('success') }}</div>
        @endif

        <form wire:submit.prevent="save">
            <div class="flex flex-col md:flex-row gap-8 items-center mb-8">

                <!-- Infos principales -->
                <div class="flex-1 w-full space-y-2">
                    <div class="font-bold text-2xl text-gray-50">{{ $form['name'] }}</div>
                    <div class="text-lg text-gray-300">{{ $form['email'] }}</div>
                    <div class="text-gray-400 text-base pt-2">
                        <span class="opacity-70">Inscrit le </span>
                        <span class="font-semibold">
                            {{ Auth::user()->created_at->format('d/m/Y à H:i') }}
                        </span>
                    </div>
                </div>
                <!-- Avatar preview -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-2xl border-2 border-white shadow"
                        style="background: {{ $form['couleur'] ?? '#7c3aed' }};">
                        {{ strtoupper(mb_substr($form['name'], 0, 1)) }}
                    </div>
                    <div class="mt-2 text-gray-400 text-xs text-center">Aperçu de l'avatar</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-gray-300 mb-2">Nom d'utilisateur</label>
                    <input type="text" wire:model.defer="form.name"
                        class="w-full bg-gray-800 text-white p-3 text-md rounded-xl" required>
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Email</label>
                    <input type="email" wire:model.defer="form.email"
                        class="w-full bg-gray-800 text-white p-3 text-md rounded-xl" required>
                </div>
            </div>

            <div class="mt-8">
                <label class="block text-gray-300 mb-2 font-medium">Couleur de l'avatar</label>
                <div class="flex gap-4 justify-center mt-3 mb-2">
                    @foreach($colorPalette as $color)
                        <button type="button"
                            class="w-14 h-10 rounded-xl focus:outline-none transition-all duration-200"
                            style="
                                background: {{ $color }};
                                border: 3px solid {{ $form['couleur'] === $color ? '#fff' : 'transparent' }};"
                            wire:click="$set('form.couleur', '{{ $color }}')"
                            aria-label="Choisir la couleur {{ $color }}">
                        </button>
                    @endforeach
                </div>
            </div>

            <button type="submit"
                class="mt-10 bg-gradient-to-r from-blue-600 to-purple-700 text-white px-4 py-3 rounded-xl font-medium text-md w-full md:w-auto shadow-lg">
                Enregistrer
            </button>
        </form>
    </div>

   <div class="w-full md:w-[400px] bg-gray-900 rounded-2xl shadow-2xl px-4 py-6 md:px-8 md:py-10 flex flex-col h-fit">
    <h2 class="text-xl font-bold text-gray-200 mb-6 text-center tracking-tight">Changer mon mot de passe</h2>
<form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-3">
    @csrf
    @method('put')

    <input type="password" name="current_password" placeholder="Mot de passe actuel"
           class="w-full bg-gray-800 text-white p-3 rounded-md text-md"
           required autocomplete="current-password" />

    <x-input-error :messages="$errors->get('current_password')" class="text-pink-400 text-sm" />


    <input type="password" name="password" placeholder="Nouveau mot de passe"
           class="w-full bg-gray-800 text-white p-3 rounded-md text-md"
           required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password')" class="text-pink-400 text-sm" />


    <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe"
           class="w-full bg-gray-800 text-white p-3 rounded-md text-md"
           required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password_confirmation')" class="text-pink-400 text-sm" />


    <button type="submit"
            class="mt-4 w-full bg-gradient-to-r from-purple-700 to-blue-600 text-white font-semibold py-2 rounded-xl shadow hover:scale-105 transition text-md">
        Enregistrer le nouveau mot de passe
    </button>
</form>

@if (session('status') === 'password-updated')
    <div class="text-green-400 mt-3 text-center">Mot de passe modifié !</div>
@endif

</div>
</div>

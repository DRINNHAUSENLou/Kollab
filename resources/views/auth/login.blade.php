<x-guest-layout>
    <h2 class="text-3xl md:text-4xl font-extrabold text-center text-purple-300 mb-8">Connexion</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-7">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-md font-semibold text-purple-200 mb-1">
                Adresse email
            </label>
            <p class="text-purple-400 text-xs mb-2">
                Utilise ton adresse utilisée lors de la création du compte.
            </p>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="Exemple : prenom.nom@gmail.com"
                class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-purple-500 shadow-sm transition px-4 py-2"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-md text-pink-400" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-md font-semibold text-purple-200 mb-1">
                Mot de passe sécurisé
            </label>
            <p class="text-purple-400 text-xs mb-2">
                Ne partage jamais ton mot de passe.
            </p>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Exemple : Sp13r!2025"
                class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-blue-600 shadow-sm transition px-4 py-2"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-md text-pink-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-2">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="rounded border-purple-600 bg-gray-900 text-purple-400 focus:ring-purple-600"
            />
            <label for="remember_me" class="ml-2 text-md text-gray-300">
                Se souvenir de moi
            </label>
        </div>

        <div class="flex flex-col items-center space-y-2 pt-3">

            <a href="{{ route('register') }}" class="text-md text-purple-300 hover:text-white underline">
                Créer un compte
            </a>

            <button type="submit"
                class="w-full mt-4 bg-purple-900 hover:from-purple-500 hover:to-blue-800 text-white font-bold py-2 rounded-full transition shadow-lg border-0">
                Se connecter
            </button>
        </div>
    </form>
</x-guest-layout>

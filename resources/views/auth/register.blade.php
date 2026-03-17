<x-guest-layout>
    <h2 class="text-3xl md:text-4xl font-extrabold text-center text-purple-300 mb-8">
        Créer un compte
    </h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-7">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-md font-semibold text-purple-200 mb-1">
                Nom complet
            </label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Exemple : Jean Dupont"
                class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-purple-500 shadow-sm transition px-4 py-2"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-md text-pink-400" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-md font-semibold text-purple-200 mb-1">
                Adresse email
            </label>
            <p class="text-purple-400 text-xs mb-2">
                Entre une adresse valide pour recevoir les notifications du projet.
            </p>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
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
                Choisis un mot de passe solide, et ne le partage jamais.
            </p>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Exemple : Sp13r!2025"
                class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-blue-600 shadow-sm transition px-4 py-2"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-md text-pink-400" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-md font-semibold text-purple-200 mb-1">
                Confirme ton mot de passe
            </label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Répète ton mot de passe"
                class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-blue-600 shadow-sm transition px-4 py-2"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-md text-pink-400" />
        </div>

        <div class="flex flex-col items-center space-y-2 pt-3">
            <a href="{{ route('login') }}"
               class="text-md text-purple-300 hover:text-white underline">
                Déjà inscrit ? Connecte-toi
            </a>

            <button type="submit"
                    class="w-full mt-4 bg-purple-900 hover:from-purple-500 hover:to-blue-800 text-white font-bold py-2 rounded-full transition shadow-lg border-0">
                S'inscrire
            </button>
        </div>
    </form>
</x-guest-layout>

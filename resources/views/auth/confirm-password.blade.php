<x-guest-layout>
    <h2 class="text-2xl md:text-3xl font-extrabold text-center text-purple-300 mb-7">Confirmation requise</h2>

    <div class="mb-6 text-md text-purple-200 text-center">
        Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-7">
        @csrf

        <!-- Mot de passe -->
        <div>
            <label for="password" class="block text-sm font-semibold text-purple-200 mb-1">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-purple-500 shadow-sm transition px-4 py-2" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-pink-400" />
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit"
                class="bg-purple-900 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full transition shadow-lg border-0">
                Confirmer
            </button>
        </div>
    </form>
</x-guest-layout>

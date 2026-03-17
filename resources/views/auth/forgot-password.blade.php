<x-guest-layout>
    <h2 class="text-2xl md:text-3xl font-extrabold text-center text-purple-300 mb-7">Réinitialiser le mot de passe</h2>

    <div class="mb-6 text-md text-purple-200 text-center">
        Mot de passe oublié ? Indique simplement ton adresse e-mail ci-dessous et nous t’enverrons un lien pour en choisir un nouveau.
    </div>

    <!-- Statut de session -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-7">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-purple-200 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-purple-500 shadow-sm transition px-4 py-2" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-pink-400" />
        </div>

        <div class="flex items-center justify-end pt-2">
            <button type="submit"
                class="bg-purple-900 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full transition shadow-lg border-0">
                Envoyer le lien de réinitialisation
            </button>
        </div>
    </form>
</x-guest-layout>

<x-guest-layout>
    <h2 class="text-2xl md:text-3xl font-extrabold text-center text-purple-300 mb-7">
        Réinitialiser votre mot de passe
    </h2>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-7">
        @csrf

        <!-- Jeton de réinitialisation -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-purple-200 mb-1">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-purple-500 shadow-sm transition px-4 py-2" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-pink-400" />
        </div>

        <!-- Mot de passe -->
        <div>
            <label for="password" class="block text-sm font-semibold text-purple-200 mb-1">Nouveau mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-blue-600 shadow-sm transition px-4 py-2" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-pink-400" />
        </div>

        <!-- Confirmation du mot de passe -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-purple-200 mb-1">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full rounded-full border border-purple-700 bg-gray-800 text-purple-100 placeholder-purple-400 focus:ring-2 focus:ring-blue-600 shadow-sm transition px-4 py-2" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-pink-400" />
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit"
                class="bg-purple-900 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full transition shadow-lg border-0">
                Réinitialiser le mot de passe
            </button>
        </div>
    </form>
</x-guest-layout>

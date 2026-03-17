<x-guest-layout>
    <h2 class="text-2xl md:text-3xl font-extrabold text-center text-purple-300 mb-7">
        Vérification de l’adresse e-mail
    </h2>

    <div class="mb-6 text-md text-purple-200 text-center">
        Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous n’avez pas reçu l’e-mail, nous vous en enverrons un nouveau avec plaisir.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm text-green-500 text-center">
            Un nouveau lien de vérification a été envoyé à l’adresse e-mail fournie lors de l’inscription.
        </div>
    @endif

    <div class="mt-4 flex flex-col md:flex-row items-center justify-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="bg-purple-900 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full transition shadow-lg border-0">
                Renvoyer l’email de vérification
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="underline text-sm text-purple-300 hover:text-white transition rounded-md focus:outline-none focus:ring-2 focus:ring-purple-700">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mes projets | Kollab</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 min-h-screen flex flex-col text-gray-100">

<!-- BAR NAV -->
<nav class="bg-gradient-to-r from-purple-800 to-blue-900 text-gray-100 p-4 flex justify-between items-center shadow-md">
  <div class="flex justify-center items-center">
    <a href="{{ url('/accueil_projet') }}" class="text-white focus:outline-none">
      <svg class="w-9 h-9 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 576">
        <path fill="currentColor" d="M108 72C68.2 72 36 104.2 36 144L36 180C36 197 41.9 212.7 51.8 225C41.9 237.3 36 253 36 270L36 306C36 323 41.9 338.7 51.8 351C41.9 363.3 36 379 36 396L36 432C36 471.8 68.2 504 108 504L468 504C507.8 504 540 471.8 540 432L540 396C540 379 534.1 363.3 524.2 351C534.1 338.7 540 323 540 306L540 270C540 253 534.1 237.3 524.2 225C534.1 212.7 540 197 540 180L540 144C540 104.2 507.8 72 468 72L108 72zM504 144C504 163.9 487.9 180 468 180L108 180C88.1 180 72 163.9 72 144C72 124.1 88.1 108 108 108L468 108C487.9 108 504 124.1 504 144zM504 270C504 289.9 487.9 306 468 306L108 306C88.1 306 72 289.9 72 270C72 250.1 88.1 234 108 234L468 234C487.9 234 504 250.1 504 270zM504 396C504 415.9 487.9 432 468 432L108 432C88.1 432 72 415.9 72 396C72 376.1 88.1 360 108 360L468 360C487.9 360 504 376.1 504 396z"/>
      </svg>
    </a>
    <p class="text-xl font-bold">Kollab</p>
  </div>
  <div class="flex items-center space-x-4 mr-50">
        <a href="{{ route('notifications.index') }}" class="relative inline-block">
            <svg class="h-9 w-9 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path fill="white" d="M320 64C302.3 64 288 78.3 288 96L288 99.2C215 114 160 178.6 160 256L160 277.7C160 325.8 143.6 372.5 113.6 410.1L103.8 422.3C98.7 428.6 96 436.4 96 444.5C96 464.1 111.9 480 131.5 480L508.4 480C528 480 543.9 464.1 543.9 444.5C543.9 436.4 541.2 428.6 536.1 422.3L526.3 410.1C496.4 372.5 480 325.8 480 277.7L480 256C480 178.6 425 114 352 99.2L352 96C352 78.3 337.7 64 320 64zM258 528C265.1 555.6 290.2 576 320 576C349.8 576 374.9 555.6 382 528L258 528z"/>
            </svg>
        @if(!empty($unreadNotificationsCount) && $unreadNotificationsCount > 0)
            <span
            class="absolute top-0 right-0 rounded-full bg-red-500 text-white text-xs px-2 py-0.5 font-bold shadow"
            style="transform: translate(25%, -25%);"
            >
            {{ $unreadNotificationsCount }}
            </span>
        @endif
        </a>

            <div class="relative inline-block text-left">
                <button id="profileBtn" class="flex items-center gap-3 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-700 hover:opacity-80 text-white rounded-lg shadow-md transition-all duration-300">
                        <span class="w-8 h-8 flex items-center justify-center rounded-full text-white font-bold text-lg border-2 border-white shadow transition leading-none"
                            style="background: {{ Auth::user()->couleur ?? '#7c3aed' }};"
                            title="{{ Auth::user()->name }}">
                            {{ strtoupper(mb_substr(Auth::user()->name ?? '', 0, 1)) }}
                        </span>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-50">
                            <div class="p-4 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
                            <div class="font-semibold">{{ Auth::user()->name }}</div>
                            <div class="text-sm opacity-80">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="{{ route('user.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 transition">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-purple-50 transition">
                                Déconnexion
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</nav>

<div class="flex flex-1">

  <!-- SIDEBAR -->
<aside id="sidebar" class="bg-purple-800 text-white w-14 flex flex-col items-center py-6">
  </aside>

  <!-- MAIN -->
  <main class="flex-1 bg-gray-950 p-6 overflow-x-hidden text-gray-100 ml-4">


<section class="mb-12 mt-5">
    <div class="flex items-center justify-between mb-8 mt-4">
    <h2 class="text-2xl font-bold text-purple-400">Mes projets</h2>
    <a href="{{ route('projet.create') }}"
        class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium mr-7 px-5 py-2.5 rounded-xl shadow-lg hover:shadow-2xl hover:scale-[1.03] transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:rotate-6 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Créer un projet</span>
    </a>
    </div>

  @if($projets->isEmpty())
    <p class="text-gray-400 text-sm italic">Aucun projet pour le moment.</p>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      @foreach($projets as $projet)
        <a href="{{ route('projet.show', $projet->id_projet) }}"
           class="relative bg-gray-900/80 border border-gray-800 rounded-2xl p-5 shadow-md hover:shadow-2xl hover:scale-[1.02] transition-transform duration-300 ease-out group overflow-hidden">

          <!-- Effet de bord lumineux -->
          <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-600/30 to-blue-500/20 opacity-0 group-hover:opacity-100 blur-md transition duration-500"></div>

          <div class="relative z-10 text-left">
            <div class="flex items-center justify-between mb-2">
              <h3 class="text-lg font-semibold text-purple-300 truncate">{{ $projet->nom }}</h3>
              <span class="text-xs px-2 py-1 rounded-md bg-purple-800/40 text-purple-200">
                {{ ucfirst($projet->priorite ?? 'Normale') }}
              </span>
            </div>

            <p class="text-gray-300 text-sm mb-3 line-clamp-2">{{ $projet->description ?? 'Aucune description' }}</p>

            <p class="text-sm text-gray-400">
                Statut :
                <span class="
                    @if($projet->statut == 'à faire') text-purple-400
                    @elseif($projet->statut == 'en cours') text-green-500
                    @else text-gray-500
                    @endif font-medium
                ">
                    {{ ucfirst($projet->statut) }}
                </span>
            </p>
          </div>

        @php
            $membres = $projet->membresListe->take(3);
            $nbTotal = $projet->membresListe->count();
        @endphp
        <div class="absolute bottom-3 right-3 flex -space-x-3">
            @foreach($membres as $membre)
            <div class="w-8 h-8 flex items-center justify-center rounded-full text-white font-bold text-sm border border-white shadow relative z-10 hover:z-20 transition"
                style="background: {{ $membre->couleur ?? '#7c3aed' }};"
                title="{{ $membre->name }}">
                {{ strtoupper(substr($membre->name ?? '', 0, 1)) }}
            </div>
            @endforeach
            @if($nbTotal > 3)
                <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-600 text-white font-bold text-sm border border-white shadow relative z-10 hover:z-20 transition"
                    title="Et {{ $nbTotal-3 }} membre(s) de plus">
                    +{{ $nbTotal-3 }}
                </div>
            @endif
        </div>

        </a>
      @endforeach
    </div>
  @endif
</section>

<section class="mb-12">
<h2 class="text-2xl font-bold text-purple-400 mb-8">Partagés avec moi</h2>

@if($projetsPartages->isEmpty())
  <p class="text-gray-400 text-sm italic">Aucun projet partagé avec vous.</p>
@else
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    @foreach($projetsPartages as $projet)
      <a href="{{ route('projet.show', $projet->id_projet) }}"
         class="relative bg-gray-900/80 border border-gray-800 rounded-2xl p-5 shadow-md hover:shadow-2xl hover:scale-[1.02] transition-transform duration-300 ease-out group overflow-hidden">

        <!-- Effet de bord lumineux -->
        <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-600/30 to-blue-500/20 opacity-0 group-hover:opacity-100 blur-md transition duration-500"></div>

        <div class="relative z-10 text-left">
          <div class="flex items-center justify-between mb-2">
            <h3 class="text-lg font-semibold text-purple-300 truncate">{{ $projet->nom }}</h3>
            <span class="text-xs px-2 py-1 rounded-md bg-purple-800/40 text-purple-200">
              {{ ucfirst($projet->priorite ?? 'Normale') }}
            </span>
          </div>

          <p class="text-gray-300 text-sm mb-3 line-clamp-2">{{ $projet->description ?? 'Aucune description' }}</p>

            <p class="text-sm text-gray-400">
                Statut :
                <span class=" @if($projet->statut == 'à faire') text-purple-400
                    @elseif($projet->statut == 'en cours') text-green-500
                    @else text-gray-500
                    @endif font-medium ">
                    {{ ucfirst($projet->statut) }}
                </span>
            </p>
        </div>
        @php
            $membres = $projet->membresListe->take(3);
            $nbTotal = $projet->membresListe->count();
        @endphp
        <div class="absolute bottom-3 right-3 flex -space-x-3">
            @foreach($membres as $membre)
            <div class="w-8 h-8 flex items-center justify-center rounded-full text-white font-bold text-sm border border-white shadow relative z-10 hover:z-20 transition"
                style="background: {{ $membre->couleur ?? '#7c3aed' }};"
                title="{{ $membre->name }}">
                {{ strtoupper(substr($membre->name ?? '', 0, 1)) }}
            </div>
            @endforeach
            @if($nbTotal > 3)
            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-600 text-white font-bold text-sm border border-white shadow relative z-10 hover:z-20 transition"
                    title="Et {{ $nbTotal-3 }} membre(s) de plus">
                    +{{ $nbTotal-3 }}
                </div>
            @endif
        </div>
      </a>
    @endforeach
  </div>
@endif

</section>
  </main>


<script>
  const profileBtn = document.getElementById('profileBtn');
  const dropdown = document.getElementById('profileDropdown');

  // Ouvre ou ferme le menu quand on clique sur le bouton
  profileBtn.addEventListener('click', (event) => {
    event.stopPropagation(); // Empêche la propagation du clic sur le document
    dropdown.classList.toggle('hidden');
  });

  // Ferme le dropdown quand on clique ailleurs
  document.addEventListener('click', (event) => {
    // Vérifie que le clic n’est pas dans le bouton ni dans le menu
    if (!dropdown.contains(event.target) && !profileBtn.contains(event.target)) {
      dropdown.classList.add('hidden');
    }
  });

const profileButton = document.getElementById('profileMenuButton');
const profileDropdown = document.getElementById('profileDropdown');

profileButton.addEventListener('click', () => {
  profileDropdown.classList.toggle('hidden');
});

document.addEventListener('click', (e) => {
  if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
    profileDropdown.classList.add('hidden');
  }
});
</script>

</body>
</html>

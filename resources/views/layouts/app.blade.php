<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Kollab')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @stack('styles')
  @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

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
            <a href="{{ route('user.index') }}"
            class="block px-4 py-2 text-gray-700 hover:bg-purple-50 transition">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-purple-50 transition">
                Déconnexion
            </button>
            </form>
        </div>
    </div>

</nav>

<div class="flex flex-1">
<aside id="sidebar" class="bg-purple-800 text-white w-14 flex flex-col items-center py-6">
  <nav class="flex-1 flex flex-col items-center w-full">
        <a href="{{ url('/accueil_projet') }}"
        class="group flex items-center justify-center w-12 h-12 mb-3 rounded-full transition hover:bg-white/20">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                class="sidebar-icon w-8 h-8 text-white flex-shrink-0 transition-all" fill="none">
                <path fill="currentColor" d="M304 70.1C313.1 61.9 326.9 61.9 336 70.1L568 278.1C577.9 286.9 578.7 302.1 569.8 312C560.9 321.9 545.8 322.7 535.9 313.8L527.9 306.6L527.9 511.9C527.9 547.2 499.2 575.9 463.9 575.9L175.9 575.9C140.6 575.9 111.9 547.2 111.9 511.9L111.9 306.6L103.9 313.8C94 322.6 78.9 321.8 70 312C61.1 302.2 62 287 71.8 278.1L304 70.1zM320 120.2L160 263.7L160 512C160 520.8 167.2 528 176 528L224 528L224 424C224 384.2 256.2 352 296 352L344 352C383.8 352 416 384.2 416 424L416 528L464 528C472.8 528 480 520.8 480 512L480 263.7L320 120.3zM272 528L368 528L368 424C368 410.7 357.3 400 344 400L296 400C282.7 400 272 410.7 272 424L272 528z"/>
            </svg>
        </a>
        @if(isset($projet))
        <a href="{{ route('projet.show', $projet->id_projet) }}"
        class="group flex items-center justify-center w-12 h-12 mb-3 rounded-full transition hover:bg-white/20">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="sidebar-icon w-7 h-7 text-pink-300 group-hover:text-pink-400 flex-shrink-0 transition-all" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h6v6H3V3zm0 12h6v6H3v-6zm12-12h6v6h-6V3zm0 12h6v6h-6v-6z"/>
            </svg>
        </a>
        <a href="{{ route('tache.index', $projet->id_projet) }}"
        class="group flex items-center justify-center w-12 h-12 mb-3 rounded-full transition hover:bg-white/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon w-8 h-8 text-blue-300 group-hover:text-blue-400 flex-shrink-0 transition-all"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </a>
        <a href="{{ route('projet.sprints.index', $projet->id_projet) }}"
        class="group flex items-center justify-center w-12 h-12 mb-3 rounded-full transition hover:bg-white/20">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="sidebar-icon w-8 h-8 text-green-300 group-hover:text-green-400 flex-shrink-0 transition-all" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </a>
        @endif
    </nav>
</aside>





  <!-- MAIN CONTENT -->
  <main class="flex-1 flex flex-col bg-gray-950 text-gray-100 p-6 md:p-10 overflow-hidden">
    @yield('content')
  </main>

<script>


const profileBtn = document.getElementById('profileBtn');
const dropdown = document.getElementById('profileDropdown');

profileBtn.addEventListener('click', (event) => {
  event.stopPropagation();
  dropdown.classList.toggle('hidden');
});

document.addEventListener('click', (event) => {
  if (!dropdown.contains(event.target) && !profileBtn.contains(event.target)) {
    dropdown.classList.add('hidden');
  }
});
</script>

@stack('scripts')
@livewireScripts
</body>
</html>

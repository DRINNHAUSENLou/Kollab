@props(['title'])

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Kollab'}}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-700 min-h-screen flex flex-col text-gray-100">

<!-- BAR NAV -->
<nav class="bg-gradient-to-r from-purple-800 to-blue-900 text-gray-100 p-4 flex justify-between items-center shadow-md">
  <div class="flex justify-center items-center">
    <button id="toggleSidebar" class="text-white focus:outline-none">
      <svg class="w-9 h-9 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 576">
        <path fill="currentColor" d="M108 72C68.2 72 36 104.2 36 144L36 180C36 197 41.9 212.7 51.8 225C41.9 237.3 36 253 36 270L36 306C36 323 41.9 338.7 51.8 351C41.9 363.3 36 379 36 396L36 432C36 471.8 68.2 504 108 504L468 504C507.8 504 540 471.8 540 432L540 396C540 379 534.1 363.3 524.2 351C534.1 338.7 540 323 540 306L540 270C540 253 534.1 237.3 524.2 225C534.1 212.7 540 197 540 180L540 144C540 104.2 507.8 72 468 72L108 72zM504 144C504 163.9 487.9 180 468 180L108 180C88.1 180 72 163.9 72 144C72 124.1 88.1 108 108 108L468 108C487.9 108 504 124.1 504 144zM504 270C504 289.9 487.9 306 468 306L108 306C88.1 306 72 289.9 72 270C72 250.1 88.1 234 108 234L468 234C487.9 234 504 250.1 504 270zM504 396C504 415.9 487.9 432 468 432L108 432C88.1 432 72 415.9 72 396C72 376.1 88.1 360 108 360L468 360C487.9 360 504 376.1 504 396z"/>
      </svg>
    </button>
    <p class="text-xl font-bold">Kollab</p>
  </div>
  <div class="flex items-center space-x-4 mr-50">
    <div class="relative">
      <input type="text" placeholder="Rechercher"
             class="pl-10 pr-4 py-1 rounded-full border border-gray-700 bg-gray-700 text-gray-100 focus:outline-none focus:ring focus:ring-purple-600 w-48 sm:w-72">
      <svg xmlns="http://www.w3.org/2000/svg"
           class="h-4 w-4 absolute left-3 top-2 text-gray-300" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
      </svg>
    </div>
    <svg class="h-9 w-9 text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
      <path d="M320 64C302.3 64 288 78.3 288 96L288 99.2C215 114 160 178.6 160 256L160 277.7C160 325.8 143.6 372.5 113.6 410.1L103.8 422.3C98.7 428.6 96 436.4 96 444.5C96 464.1 111.9 480 131.5 480L508.4 480C528 480 543.9 464.1 543.9 444.5C543.9 436.4 541.2 428.6 536.1 422.3L526.3 410.1C496.4 372.5 480 325.8 480 277.7L480 256C480 178.6 425 114 352 99.2L352 96C352 78.3 337.7 64 320 64zM258 528C265.1 555.6 290.2 576 320 576C349.8 576 374.9 555.6 382 528L258 528z"/>
    </svg>
    <div class="relative">
      <button id="profileMenuButton" class="h-9 w-9 focus:outline-none">
        <svg class="h-9 w-9 text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
          <path d="M64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320z"/>
        </svg>
      </button>

      <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-purple-800 text-white rounded-md shadow-lg overflow-hidden z-50">
        <a href="#" class="block px-4 py-2 hover:bg-purple-700">Profil</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 hover:bg-purple-700">Déconnexion</button>
        </form>
      </div>
    </div>
  </div>
</nav>

<div class="flex flex-1">
    <!-- SIDEBAR -->
    <aside id="sidebar" class="bg-purple-800 text-white w-16 sm:w-20 transition-all duration-300 overflow-hidden flex flex-col">
    <nav class="flex-1 mt-4 space-y-4">

        <!-- Accueil : liste des projets -->
        <a href="{{ url('/accueil_projet') }}" class="flex items-center px-4 py-2 hover:bg-purple-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-10 h-10 text-purple-300 flex-shrink-0">
            <path fill="currentColor" d="M304 70.1C313.1 61.9 326.9 61.9 336 70.1L568 278.1C577.9 286.9 578.7 302.1 569.8 312C560.9 321.9 545.8 322.7 535.9 313.8L527.9 306.6L527.9 511.9C527.9 547.2 499.2 575.9 463.9 575.9L175.9 575.9C140.6 575.9 111.9 547.2 111.9 511.9L111.9 306.6L103.9 313.8C94 322.6 78.9 321.8 70 312C61.1 302.2 62 287 71.8 278.1L304 70.1zM320 120.2L160 263.7L160 512C160 520.8 167.2 528 176 528L224 528L224 424C224 384.2 256.2 352 296 352L344 352C383.8 352 416 384.2 416 424L416 528L464 528C472.8 528 480 520.8 480 512L480 263.7L320 120.3zM272 528L368 528L368 424C368 410.7 357.3 400 344 400L296 400C282.7 400 272 410.7 272 424L272 528z"/>
        </svg>
        <span class="ml-3 hidden sidebar-text text-purple-300 font-semibold">Mes projets</span>
        </a>

        <!-- Tableau de bord -->
        <a href="{{ route('projet.index') }}" class="flex items-center px-4 py-2 hover:bg-purple-700">
            Tableau de bord
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-10 h-10 text-purple-300 flex-shrink-0">
            <path fill="currentColor" d="M352 224L352 320L480 320L480 224L352 224zM288 224L160 224L160 320L288 320L288 224zM96 384L96 160C96 124.7 124.7 96 160 96L480 96C515.3 96 544 124.7 544 160L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 384zM480 384L352 384L352 480L480 480L480 384zM288 480L288 384L160 384L160 480L288 480z"/>
        </svg>
        <span class="ml-3 hidden sidebar-text text-purple-300 font-semibold">Tableau de bord</span>
        </a>

        <!-- Kanban -->
        <a href="{{ route('epic.index', $projet->id_projet) }}
         " class="flex items-center px-4 py-2 hover:bg-purple-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-10 h-10 text-purple-300 flex-shrink-0">
            <path fill="currentColor" d="M96 160C96 124.7 124.7 96 160 96L480 96C515.3 96 544 124.7 544 160L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 160zM160 224L160 480L288 480L288 224L160 224zM480 224L352 224L352 480L480 480L480 224z"/>
        </svg>
        <span class="ml-3 hidden sidebar-text text-purple-300 font-semibold">Kanban</span>
        </a>

        <!-- Roadmap -->
        <a href="{{ route('roadmap.show', $projet->id_projet) }}" class="flex items-center px-4 py-2 hover:bg-purple-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-10 h-10 text-purple-300 flex-shrink-0">
            <path fill="currentColor" d="M224 64C241.7 64 256 78.3 256 96L256 128L384 128L384 96C384 78.3 398.3 64 416 64C433.7 64 448 78.3 448 96L448 128L480 128C515.3 128 544 156.7 544 192L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 192C96 156.7 124.7 128 160 128L192 128L192 96C192 78.3 206.3 64 224 64zM160 304L160 336C160 344.8 167.2 352 176 352L208 352C216.8 352 224 344.8 224 336L224 304C224 295.2 216.8 288 208 288L176 288C167.2 288 160 295.2 160 304zM288 304L288 336C288 344.8 295.2 352 304 352L336 352C344.8 352 352 344.8 352 336L352 304C352 295.2 344.8 288 336 288L304 288C295.2 288 288 295.2 288 304zM432 288C423.2 288 416 295.2 416 304L416 336C416 344.8 423.2 352 432 352L464 352C472.8 352 480 344.8 480 336L480 304C480 295.2 472.8 288 464 288L432 288zM160 432L160 464C160 472.8 167.2 480 176 480L208 480C216.8 480 224 472.8 224 464L224 432C224 423.2 216.8 416 208 416L176 416C167.2 416 160 423.2 160 432zM304 416C295.2 416 288 423.2 288 432L288 464C288 472.8 295.2 480 304 480L336 480C344.8 480 352 472.8 352 464L352 432C352 423.2 344.8 416 336 416L304 416zM416 432L416 464C416 472.8 423.2 480 432 480L464 480C472.8 480 480 472.8 480 464L480 432C480 423.2 472.8 416 464 416L432 416C423.2 416 416 423.2 416 432z"/>
        </svg>
        <span class="ml-3 hidden sidebar-text text-purple-300 font-semibold">Roadmap</span>
        </a>

        <!-- Statistiques -->
        <a href="{{ route('stats.show', $projet->id_projet) }}" class="flex items-center px-4 py-2 hover:bg-purple-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-10 h-10 text-purple-300 flex-shrink-0">
            <path fill="currentColor" d="M96 480H544V512H96V480ZM96 384H208V416H96V384ZM96 288H336V320H96V288ZM96 192H400V224H96V192Z"/>
        </svg>
        <span class="ml-3 hidden sidebar-text text-purple-300 font-semibold">Statistiques</span>
        </a>

    </nav>
    </aside>

<main class="flex-1 bg-gray-900 p-6 overflow-x-hidden text-gray-100">
    {{ $slot }}
</main>

</div>

<!-- FOOTER -->
<footer class="bg-gradient-to-r from-purple-800 to-blue-900 text-gray-400 py-5">
  <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-around space-y-4 md:space-y-0 text-sm">
      <div>© 2025 | DRINNHAUSEN Lou</div>
      <div class="flex space-x-6">
          <a href="/rgpd" class="hover:text-purple-300 transition">RGPD</a>
          <a href="/mentions-legales" class="hover:text-purple-300 transition">Mentions légales</a>
          <a href="/cgu" class="hover:text-purple-300 transition">CGU</a>
      </div>
  </div>
</footer>

<script>
const toggleSidebar = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');
const sidebarTexts = document.querySelectorAll('.sidebar-text');
let expanded = false;

toggleSidebar.addEventListener('click', () => {
  expanded = !expanded;
  if (expanded) {
    sidebar.classList.remove('w-16', 'sm:w-20');
    sidebar.classList.add('w-48');
    sidebarTexts.forEach(el => el.classList.remove('hidden'));
  } else {
    sidebar.classList.add('w-16', 'sm:w-20');
    sidebar.classList.remove('w-48');
    sidebarTexts.forEach(el => el.classList.add('hidden'));
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

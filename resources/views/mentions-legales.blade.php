<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mentions légales | Kollab</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 flex flex-col min-h-screen font-sans">

  <!-- NAV BAR -->
  <nav class="bg-gradient-to-r from-purple-800 to-blue-900 text-gray-100 p-4 flex justify-between items-center shadow-md">
    <div class="flex justify-center items-center space-x-3">
      <a href="{{ url('/') }}" class="text-white focus:outline-none">
        <svg class="w-9 h-9 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 576">
          <path fill="currentColor" d="M108 72C68.2 72 36 104.2 36 144L36 180C36 197 41.9 212.7 51.8 225C41.9 237.3 36 253 36 270L36 306C36 323 41.9 338.7 51.8 351C41.9 363.3 36 379 36 396L36 432C36 471.8 68.2 504 108 504L468 504C507.8 504 540 471.8 540 432L540 396C540 379 534.1 363.3 524.2 351C534.1 338.7 540 323 540 306L540 270C540 253 534.1 237.3 524.2 225C534.1 212.7 540 197 540 180L540 144C540 104.2 507.8 72 468 72L108 72zM504 144C504 163.9 487.9 180 468 180L108 180C88.1 180 72 163.9 72 144C72 124.1 88.1 108 108 108L468 108C487.9 108 504 124.1 504 144zM504 270C504 289.9 487.9 306 468 306L108 306C88.1 306 72 289.9 72 270C72 250.1 88.1 234 108 234L468 234C487.9 234 504 250.1 504 270zM504 396C504 415.9 487.9 432 468 432L108 432C88.1 432 72 415.9 72 396C72 376.1 88.1 360 108 360L468 360C487.9 360 504 376.1 504 396z" />
        </svg>
      </a>
      <p class="text-xl font-bold">Kollab</p>
    </div>
    <div class="space-x-4 text-sm font-medium">
      @guest
      <a href="{{ url('/login') }}" class="border border-purple-500 text-purple-300 px-3 py-1 rounded-full hover:bg-purple-700 hover:text-white transition font-semibold">Connexion</a>
      @endguest

      @auth
      <a href="{{ url('/accueil_projet') }}" class="border border-purple-500 text-purple-300 px-3 py-1 rounded-full hover:bg-purple-700 hover:text-white transition font-semibold">Connexion</a>
      @endauth
    </div>
  </nav>

  <div class="flex flex-1">

    <!-- MAIN -->
    <main class="flex-1 flex items-center justify-center px-4 py-12">
      <div class="bg-gray-800 bg-opacity-90 rounded-xl w-full max-w-3xl mx-auto p-8">
        <h1 class="text-3xl font-bold text-purple-300 mb-6 text-center">Mentions légales — Kollab</h1>

        <div class="space-y-5 text-gray-200 text-sm md:text-base">
          <p class="text-gray-300">
            Les informations ci-dessous constituent des mentions légales fictives destinées à illustrer la mise en page de la plateforme Kollab.
          </p>

          <h2 class="text-xl text-purple-400 font-bold mt-4">1. Éditeur du site</h2>
          <p class="text-gray-400">
            Le site « Kollab » est édité par la société <span class="text-purple-200 font-semibold">Kollab Studio SAS</span>, au capital de 10 000 €, immatriculée au RCS de Nulle Part sous le numéro 000 000 000.
          </p>
          <p class="text-gray-400">
            Siège social : 1 rue de la Collaboration, 00000 Ville Factice, France.
            Email de contact : <span class="underline text-purple-300">contact@kollab.fr</span>.
          </p>

          <h2 class="text-xl text-purple-400 font-bold mt-4">2. Hébergement</h2>
          <p class="text-gray-400">
            Le site est hébergé par l’hébergeur fictif <span class="text-purple-200 font-semibold">Host Cloud</span>, 99 avenue du Serveur, 00000 DataCity, France.
          </p>

          <h2 class="text-xl text-purple-400 font-bold mt-4">3. Propriété intellectuelle</h2>
          <p class="text-gray-400">
            L’ensemble des éléments graphiques, textes et mises en page de Kollab présentés sur cette page sont purement fictifs et n’ont aucune portée juridique.
          </p>

          <h2 class="text-xl text-purple-400 font-bold mt-4">4. Responsabilité</h2>
          <p class="text-gray-400">
            L’éditeur ne saurait être tenu responsable de tout dommage imaginaire direct ou indirect résultant de l’utilisation tout aussi imaginaire de ce site de démonstration.
          </p>

          <h2 class="text-xl text-purple-400 font-bold mt-4">5. Données personnelles</h2>
          <p class="text-gray-400">
            Aucune donnée personnelle réelle n’est collectée via cette page d’exemple. Toute référence à des traitements de données est purement illustrative.
          </p>

          <h2 class="text-xl text-purple-400 font-bold mt-4">6. Contact</h2>
          <p class="text-gray-400">
            Pour toute question relative à ces mentions légales fictives, vous pouvez écrire à
            <span class="underline text-purple-300">legal@kollab.fr</span>.
          </p>
        </div>
      </div>
    </main>
  </div>

  <!-- FOOTER -->
  <footer class="bg-gray-900 text-gray-400 py-5">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-around space-y-4 md:space-y-0 text-sm">
      <div>© 2025 | DRINNHAUSEN Lou</div>
      <div class="flex space-x-6">
        <a href="/rgpd" class="hover:text-purple-300 transition">RGPD</a>
        <a href="/mentions-legales" class="hover:text-purple-300 transition">Mentions légales</a>
        <a href="/cgu" class="hover:text-purple-300 transition">CGU</a>
      </div>
    </div>
  </footer>

</body>
</html>

<h1 align="center">Kollab</h1>

<p align="center">
Kollab est une plateforme collaborative de gestion de projets développée avec **Laravel**, relié à une base de données **MySQL**, permettant aux équipes d'organiser et de suivre leurs projets selon une méthodologie **Agile** et **Kanban**.

Le site intègre un système d'authentification sécurisé, un système de notification en temps réel, et propose une gestion hiérarchisée du travail : **Sprints** contenant des **Épics**, eux-mêmes divisés en **Tâches**.
</p>

<h2>Ci dessous une vidéo de démonstration des fonctionnalités de mon application</h2>

https://youtu.be/qbVq7aVB1rk

<img width="1855" height="909" alt="Capture d&#39;écran 2026-03-30 203859" src="https://github.com/user-attachments/assets/97cb14de-ed1f-4eec-b6f0-983f2340cc3c" />

<h2>Actions à faire pour mettre en place le projet</h2>

<ul>
  <li>
    <strong>Cloner le dépôt :</strong><br>
    <pre><code>git clone https://github.com/DRINNHAUSENLou/Kollab.git
cd Kollab</code></pre>
  </li>

  <li>
    <strong>Installer les dépendances PHP et Node :</strong><br>
    <pre><code>composer install
npm install</code></pre>
  </li>

  <li>
    <strong>Créer le fichier .env et générer la clé de l’application :</strong><br>
    <pre><code>cp .env.example .env
php artisan key:generate</code></pre>
  </li>

  <li>
    <strong>Créer la base de données :</strong> <br>
    Créer une base nommée <strong>kollab</strong> dans phpMyAdmin ou via MySQL.
  </li>

  <li>
    <strong>Lancer les migrations et compiler les assets :</strong><br>
    <pre><code>php artisan migrate
npm run build</code></pre>
  </li>

  <li>
    <strong>Démarrer le serveur local :</strong><br>
    <pre><code>php artisan serve</code></pre>
  </li>

  <li>
    <strong>Accéder à l’application :</strong><br>
    <a href="http://localhost:8000">http://localhost:8000</a>
  </li>
</ul>

<h3 align="left">Langages et Outils :</h3>
<p align="left">
  <a href="https://laravel.com" target="_blank" rel="noreferrer">
    <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain.svg" alt="laravel" width="40" height="40"/>
  </a>
  <a href="https://www.php.net" target="_blank" rel="noreferrer">
    <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/>
  </a>
  <a href="https://www.mysql.com/" target="_blank" rel="noreferrer">
    <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="40" height="40"/>
  </a>
  <a href="https://vuejs.org/" target="_blank" rel="noreferrer">
    <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/vuejs/vuejs-original-wordmark.svg" alt="vuejs" width="40" height="40"/>
  </a>
  <a href="https://tailwindcss.com/" target="_blank" rel="noreferrer">
    <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/tailwindcss/tailwindcss-plain.svg" alt="tailwindcss" width="40" height="40"/>
  </a>
  <a href="https://www.javascript.com/" target="_blank" rel="noreferrer">
    <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/javascript/javascript-original.svg" alt="javascript" width="40" height="40"/>
  </a>
</p>

<h1 align="center">Kollab</h1>

<p align="center">
Kollab est une application de gestion de projet développée avec Laravel et connectée à une base de données MySQL.

Inspirée des méthodes agiles, elle permet de créer des projets, de planifier le travail en sprints et de les organiser en epics (regroupements de tâches à long terme). L’avancement peut être suivi à l’aide d’un calendrier stylisé et d’un tableau de bord.
Chaque projet peut impliquer plusieurs utilisateurs avec différents rôles (chef, éditeur, membre), ainsi qu’un système de notifications pour maintenir tous les participants informés.
Kollab offre ainsi aux équipes un environnement structuré pour organiser et suivre leurs projets selon les méthodologies Agile et Kanban.
</p>

<h2> Fonctionnalités</h2>

<ul>
  <li>Création et gestion de projets</li>
  <li>Organisation en sprints, epics et tâches</li>
  <li>Gestion des utilisateurs et rôles (chef, éditeur, lecteur)</li>
  <li>Tableau de bord de suivi</li>
  <li>Calendrier des de suivi des sprints</li>
  <li>Système de notifications</li>
</ul>

<h2>Ci dessous une vidéo de démonstration des fonctionnalités de mon application</h2>
<p align="center">
  <a href="https://youtu.be/qbVq7aVB1rk">
    <img src="https://img.youtube.com/vi/qbVq7aVB1rk/0.jpg" alt="Demo vidéo"/>
  </a>
</p>

<h2> Ce que ce projet m’a apporté</h2>

<ul>
  <li>Conception complète d’une application web avec Laravel</li>
  <li>Mise en place d’une architecture MVC</li>
  <li>Gestion des relations en base de données (MySQL)</li>
  <li>Implémentation d’un système de rôles et permissions</li>
  <li>Utilisation des méthodes Agile (sprints, organisation en epics)</li>
  <li>Amélioration de mes compétences en UX/UI et organisation d’interface</li>
</ul>

<h2> Améliorations possibles</h2>

<ul>
  <li>Ajout de temps réel (WebSockets)</li>
  <li>Amélioration du système de notifications</li>
  <li>Ajout de statistiques avancées</li>
</ul>

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

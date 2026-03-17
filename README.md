# Kollab

Kollab est une plateforme collaborative de gestion de projets développée avec Laravel, relié à une base de données MySQL, permettant aux équipes d'organiser et de suivre leurs projets selon une méthodologie Agile et Kanban.
Le site intègre un système d'authentification sécurisé, un système de notification en temps réel, et propose une gestion hiérarchisée du travail : **Sprints** contenant des **Épics**, eux-mêmes divisés en **Tâches**.

Les visiteurs peuvent consulter la présentation du site.
Les utilisateurs connectés peuvent créer des projets et deviennent automatiquement le **Chef de projet**. Depuis ce rôle, ils peuvent ajouter des collaborateurs au projet et leur attribuer des rôles : **Éditeur** (peut modifier et gérer les tâches) ou **Lecteur** (consultation uniquement). Ils organisent le travail via une structure flexible : créer des sprints avec des dates définies, ajouter des épics pour les grandes fonctionnalités, puis décomposer ces épics en tâches granulaires. Ils visualisent l'avancement via un tableau **Kanban** interactif (affichage des tâches par statut) et une **roadmap** calendaire des sprints.

-- Installation

git clone https://github.com/DRINNHAUSENLou/Kollab.git
cd Kollab
composer install
npm install
cp .env.example .env
php artisan key:generate
# Créer la Base de Donnée "kollab" dans phpMyAdmin
php artisan migrate
npm run build
php artisan serve


<h3 align="left">Langages et Outils:</h3> <p align="left"> <a href="https://laravel.com" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain-wordmark.svg" alt="laravel" width="40" height="40"/> </a> <a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a> <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="40" height="40"/> </a> <a href="https://vuejs.org/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/vuejs/vuejs-original-wordmark.svg" alt="vue" width="40" height="40"/> </a> <a href="https://tailwindcss.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/tailwindcss/tailwindcss-original-wordmark.svg" alt="tailwind" width="40" height="40"/> </a> <a href="https://www.javascript.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/javascript/javascript-original.svg" alt="javascript" width="40" height="40"/> </a> </p>

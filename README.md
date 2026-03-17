#  Kollab

Kollab est une plateforme collaborative de gestion de projets développée avec **Laravel**, relié à une base de données **MySQL**, permettant aux équipes d'organiser et de suivre leurs projets selon une méthodologie **Agile** et **Kanban**.

Le site intègre un système d'authentification sécurisé, un système de notification en temps réel, et propose une gestion hiérarchisée du travail : **Sprints** contenant des **Épics**, eux-mêmes divisés en **Tâches**.

## 🎯 Fonctionnalités

### Pour les visiteurs
- Consultation de la présentation du site

### Pour les utilisateurs connectés
- **Créer des projets** et devenir automatiquement Chef de projet
- **Gérer les collaborateurs** avec des rôles (Éditeur, Lecteur)
- **Organiser le travail** : Sprints → Épics → Tâches
- **Visualiser l'avancement** via tableau Kanban et Roadmap
- **Recevoir des notifications** en temps réel

### Pour l'administrateur
- Gestion complète des utilisateurs et projets
- Modération de la plateforme

## Installation rapide

-- bash
git clone https://github.com/DRINNHAUSENLou/Kollab.git
cd Kollab
composer install
npm install
cp .env.example .env
php artisan key:generate

-- Créer la Base de Données "kollab" dans phpMyAdmin

php artisan migrate
npm run build
php artisan serve

Accédez à l'application sur http://localhost:8000


-- Langages et Outils
<p align="left"> <a href="https://laravel.com" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain.svg" alt="laravel" width="45" height="45"/> </a> <a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="45" height="45"/> </a> <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="45" height="45"/> </a> <a href="https://vuejs.org/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/vuejs/vuejs-original-wordmark.svg" alt="vue" width="45" height="45"/> </a> <a href="https://tailwindcss.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/tailwindcss/tailwindcss-plain.svg" alt="tailwind" width="45" height="45"/> </a> <a href="https://www.javascript.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/javascript/javascript-original.svg" alt="javascript" width="45" height="45"/> </a> </p>


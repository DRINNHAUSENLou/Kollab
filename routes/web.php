<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\EpicController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\MembreProjetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Auth
|--------------------------------------------------------------------------
*/

Route::get('/accueil_projet', function () {
    return view('accueil_projet');
})->middleware(['auth', 'verified'])->name('accueil_projet');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});

require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Pages principales
|--------------------------------------------------------------------------
*/

// Accueil
Route::get('/', fn() => view('accueil'))->name('accueil');

// RGPD
Route::get('/rgpd', fn() => view('rgpd'))->name('rgpd');

// Mentions légales
Route::get('/mentions-legales', fn() => view('mentions-legales'))->name('mentions-legales');

// CGU
Route::get('/cgu', fn() => view('cgu'))->name('cgu');

/*
|--------------------------------------------------------------------------
| Routes Projet
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // --- PROJET ---
    Route::get('/accueil_projet', [ProjetController::class, 'index'])->name('projet.index');
    Route::get('/projet/create', [ProjetController::class, 'create'])->name('projet.create');
    Route::post('/projet', [ProjetController::class, 'store'])->name('projet.store');
    Route::get('/projet/{id}', [ProjetController::class, 'show'])->name('projet.show');
    Route::get('/projet/{id}/edit', [ProjetController::class, 'edit'])->name('projet.edit');
    Route::put('/projet/{id}', [ProjetController::class, 'update'])->name('projet.update');
    Route::delete('/projet/{id}', [ProjetController::class, 'delete'])->name('projet.delete');
    Route::post('/projet/{id}/ajouter-membre', [ProjetController::class, 'ajouterMembre'])->name('projet.ajouterMembre');

    // --- EPIC ---
    Route::prefix('projet/{id_projet}')->group(function () {
        Route::get('/epic', [EpicController::class, 'index'])->name('epic.index');
        Route::get('/epic/create', [EpicController::class, 'create'])->name('epic.create');
        Route::post('/epic', [EpicController::class, 'store'])->name('epic.store');
        Route::get('/epic/{id_epic}/edit', [EpicController::class, 'edit'])->name('epic.edit');
        Route::put('/epic/{id_epic}', [EpicController::class, 'update'])->name('epic.update');
        Route::delete('/epic/{id_epic}', [EpicController::class, 'delete'])->name('epic.delete');
    });

    // --- TACHES ---
    Route::prefix('projet/{id_projet}')->group(function () {
        Route::get('/taches', [TacheController::class, 'index'])->name('tache.index');
        Route::get('/taches/create', [TacheController::class, 'create'])->name('tache.create');
        Route::post('/taches', [TacheController::class, 'store'])->name('tache.store');
        Route::get('/taches/{id_tache}/edit', [TacheController::class, 'edit'])->name('tache.edit');
        Route::put('/taches/{id_tache}', [TacheController::class, 'update'])->name('tache.update');
        Route::delete('/taches/{id_tache}', [TacheController::class, 'delete'])->name('tache.delete');
    });

    // --- SPRINTS ---
    Route::get('projet/{projet}/sprints', [SprintController::class, 'index'])->name('projet.sprints.index');
    Route::get('projet/{projet}/sprints/create', [SprintController::class, 'create'])->name('projet.sprints.create');
    Route::post('projet/{projet}/sprints', [SprintController::class, 'store'])->name('projet.sprints.store');
    Route::delete('/sprints/{sprint}/delete', [SprintController::class, 'delete'])->name('sprint.delete');

    // Ressource Sprint
    Route::resource('sprint', SprintController::class)->except(['index', 'create', 'store']);
    Route::post('sprint/{sprint}/assign-tache', [SprintController::class, 'assignTache'])->name('sprint.assignTache');

    // --- MEMBRES ---
    Route::post('/projet/{projet}/membres', [MembreProjetController::class, 'ajouter'])->name('membre.ajouter');
    Route::delete('/projet/{projet}/membre/{membre}', [MembreProjetController::class, 'retirer'])->name('membre.retirer');
    Route::patch('/projet/{projet}/membre/{membre}/role', [MembreProjetController::class, 'changerRole'])->name('membre.role');
});

/*
|--------------------------------------------------------------------------
| Routes Annexes (Kanban, Roadmap, Stats, API)
|--------------------------------------------------------------------------
*/

// Pages liées à un projet
Route::get('/projet/{id}', [ProjetController::class, 'show'])->name('projet.show');
Route::get('/projet/{id}/kanban', [KanbanController::class, 'show'])->name('kanban.show');
Route::get('/projet/{id}/roadmap', [RoadmapController::class, 'show'])->name('roadmap.show');

// Kanban Sprint
Route::get('projet/{projet}/kanban/{sprint?}', [SprintController::class, 'kanban'])->name('projet.sprints.kanban');

// API - Sprints events
Route::get('api/projet/{projet}/sprints/events', function($projetId) {
    $sprints = \App\Models\Sprint::where('id_projet', $projetId)->get();
    $now = now();
    $events = $sprints->map(function($s) use ($now) {
        return [
            'id' => $s->id_sprint,
            'title' => $s->nom,
            'start' => $s->date_debut->format('Y-m-d'),
            'end' => $s->date_fin->copy()->addDay()->format('Y-m-d'),
        ];
    });
    return response()->json($events);
})->name('api.sprints.events');

// Autres
Route::get('/projets/{id_projet}/epics', [EpicController::class, 'index'])->name('epic.index');
Route::post('/tache/{id}/statut', [TacheController::class, 'updateStatut']);
Route::get('/users/search', [App\Http\Controllers\UserController::class, 'search'])->name('users.search');
Route::get('/user', [UserController::class, 'index'])->middleware('auth')->name('user.index');



Route::post('/projet/{id}/membres', [ProjetController::class, 'ajouterMembre'])
    ->name('projet.ajouterMembre');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');



Route::post('/notifications/{notification}/lire', [NotificationController::class, 'marquerCommeLu'])
    ->name('notifications.lire');
Route::post('/notifications/lire-tout', [NotificationController::class, 'marquerToutCommeLu'])
    ->name('notifications.lire_tout');


Route::get('/sprint/{id}/epics', [SprintController::class, 'getSprintEpics']);
Route::get('/sprints/details/{id}', [SprintController::class, 'getSprintDetails']);

Route::patch('/tache/{id_projet}/{id_tache}/status', [TacheController::class, 'updateStatus'])->middleware('auth')->name('tache.updateStatus');

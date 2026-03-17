<?php
namespace App\Http\Controllers;

use App\Models\Tache;
use App\Models\Projet;
use App\Models\Sprint;
use App\Models\Epic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class TacheController extends Controller
{
public function index($id_projet, Request $request)
{
    $projet = Projet::findOrFail($id_projet);
    $sprints = $projet->sprints()->orderBy('date_debut')->get();
    $now = now()->toDateString();

    $sprintActuel = $request->has('sprint_id')
        ? $sprints->where('id_sprint', $request->get('sprint_id'))->first()
        : Sprint::where('id_projet', $id_projet)
            ->whereDate('date_debut', '<=', $now)
            ->whereDate('date_fin', '>=', $now)
            ->first();

    if (!$sprintActuel) {
        $sprintActuel = $sprints->first();
    }

    $epics = Epic::where('id_projet', $id_projet)->get();

    $search = $request->input('search');
    $date = $request->input('date');
    $statut = $request->input('statut');

    if ($sprintActuel) {
        $tachesQuery = Tache::where('id_sprint', $sprintActuel->id_sprint)
            ->with(['epic', 'utilisateur']);
    } else {
        // Prend toutes les tâches pour ce projet même si aucun sprint
        $tachesQuery = Tache::where('id_projet', $id_projet)
            ->with(['epic', 'utilisateur']);
    }

    if ($search) {
        $tachesQuery->where(function ($q) use ($search) {
            $q->where('titre', 'LIKE', "%{$search}%")
            ->orWhereHas('utilisateur', function ($q2) use ($search) {
                $q2->where('name', 'LIKE', "%{$search}%");
            });
        });
    }
    if ($date) {
        $tachesQuery->whereDate('date_creation', $date);
    }
    if ($statut) {
        $tachesQuery->where('statut', $statut);
    }

    $taches = $tachesQuery->get();

    return view('tache.index', compact('projet', 'sprints', 'sprintActuel', 'taches', 'epics'));
}

    private function verifAccessTacheOuChef($projetId, $tache)
    {
        $projet = \App\Models\Projet::findOrFail($projetId);
        $isChef = (Auth::id() == $projet->chef_id);

        $membreProjet = \DB::table('membre_projet')
            ->where('id_projet', $projetId)
            ->where('id_utilisateur', Auth::id())
            ->first();
        $role = $membreProjet ? $membreProjet->role : null;

        if (
            !$isChef &&
            ($tache->id_utilisateur !== null && Auth::id() !== $tache->id_utilisateur) &&
            $role !== 'editeur'
        ) {
            abort(403, 'Seul le membre assigné, un éditeur ou le chef de projet peut modifier cette tâche.');
        }
    }

    public function create($id_projet, Request $request)
{
    $projet = Projet::findOrFail($id_projet);

    $sprints = $projet->sprints()->orderByDesc('date_debut')->get();

    $sprintActuelId = $request->get('sprint_id');

    if (!$sprintActuelId) {
        $now = now()->toDateString();
        $sprintEnCours = Sprint::where('id_projet', $id_projet)
            ->whereDate('date_debut', '<=', $now)
            ->whereDate('date_fin', '>=', $now)
            ->first();
        $sprintActuelId = $sprintEnCours?->id_sprint ?? $sprints->first()?->id_sprint;
    }

    $epics = Epic::where('id_projet', $id_projet)->get();

    $utilisateurs = \DB::table('membre_projet')
    ->join('users', 'membre_projet.id_utilisateur', '=', 'users.id')
    ->where('membre_projet.id_projet', $id_projet)
    ->whereIn('membre_projet.role', ['chef', 'editeur'])
    ->select('users.id', 'users.name', 'membre_projet.role')
    ->get();


    return view('tache.create', compact('projet', 'epics', 'sprints', 'sprintActuelId', 'utilisateurs'));
}



    public function store(Request $request, $id_projet)
    {
        $projet = Projet::findOrFail($id_projet);

        $request->validate([
            'titre' => 'required|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|in:basse,moyenne,haute',
            'id_epic' => 'nullable|exists:epic,id_epic',
            'id_sprint' => 'required|exists:sprint,id_sprint',
            'date_debut' => 'required|date',
            'date_fin_prevue' => 'required|date',
            'id_utilisateur' => 'sometimes|nullable|exists:users,id',
        ]);

        Tache::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'priorite' => $request->priorite,
            'statut' => $request->statut,
            'id_projet' => $id_projet,
            'id_epic' => $request->id_epic ?? null,
            'id_sprint' => $request->id_sprint,
            'id_utilisateur' => $request->id_utilisateur,
            'date_creation' => now(),
            'date_debut' => $request->date_debut,
            'date_fin_prevue' => $request->date_fin_prevue,
        ]);

        if ($request->filled('id_utilisateur')) {
            \App\Models\Notification::create([
                'projet_id' => $id_projet,
                'type' => 'tache_assignee',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $request->id_utilisateur,
                'data' => "La tâche ('{$request->titre}') t'a été assignée dans le projet '{$projet->nom}'.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        return redirect()->route('tache.index', ['id_projet' => $id_projet, 'sprint_id' => $request->id_sprint])
            ->with('success', 'Tâche ajoutée avec succès');    }

    public function edit($id_projet, $id_tache)
    {
        $projet = Projet::findOrFail($id_projet);
        $tache = Tache::findOrFail($id_tache);
        $this->verifAccessTacheOuChef($id_projet, $tache);

        // Récupérer tous les epics pour l'édition
        $epics = Epic::where('id_projet', $id_projet)->get();

        $utilisateurs = \DB::table('membre_projet')
        ->join('users', 'membre_projet.id_utilisateur', '=', 'users.id')
        ->where('membre_projet.id_projet', $id_projet)
        ->whereIn('membre_projet.role', ['chef', 'editeur'])
        ->select('users.id', 'users.name', 'membre_projet.role')
        ->get();

        return view('tache.edit', compact('projet', 'tache', 'epics', 'utilisateurs'));
    }

public function update(Request $request, $id_projet, $id_tache)
{
    $projet = Projet::findOrFail($id_projet);

    $request->validate([
        'titre' => 'required|max:255',
        'description' => 'nullable|string',
        'priorite' => 'required|in:basse,moyenne,haute',
        'id_epic' => 'nullable|exists:epic,id_epic',
        'id_utilisateur' => 'nullable|exists:users,id',
        'date_debut' => 'required|date',
        'date_fin_prevue' => 'required|date',
    ]);

    $tache = Tache::findOrFail($id_tache);
    $this->verifAccessTacheOuChef($id_projet, $tache);

    $ancienAssigne = $tache->id_utilisateur;

    $tache->update([
        'titre' => $request->titre,
        'description' => $request->description,
        'priorite' => $request->priorite,
        'id_epic' => $request->id_epic,
        'id_utilisateur' => $request->id_utilisateur,
        'date_debut' => $request->date_debut,
        'date_fin_prevue' => $request->date_fin_prevue,
    ]);

    $nouvelAssigne = $request->id_utilisateur;

    // Notif désassignation
    if ($ancienAssigne && ($nouvelAssigne != $ancienAssigne)) {
        \App\Models\Notification::create([
            'projet_id' => $id_projet,
            'type' => 'tache_unassigned',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $ancienAssigne,
            'data' => "La tâche ('{$request->titre}') ne t'es plus assignée dans le projet '{$projet->nom}'.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    // Notif (ré)assignation
    if ($nouvelAssigne && $nouvelAssigne != $ancienAssigne) {
        \App\Models\Notification::create([
            'projet_id' => $id_projet,
            'type' => 'tache_assignee',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $nouvelAssigne,
            'data' => "La tâche ('{$request->titre}') t'a été assignée dans le projet '{$projet->nom}'.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Notif automatique "en retard" (pas de doublons)
    if (
        $tache->id_utilisateur
        && $tache->date_fin_prevue
        && $tache->statut !== 'terminée'
        && $tache->date_fin_prevue < now()
    ) {
        $notifExist = \App\Models\Notification::where([
            ['projet_id', '=', $id_projet],
            ['type', '=', 'tache_retard'],
            ['notifiable_type', '=', 'App\Models\User'],
            ['notifiable_id', '=', $tache->id_utilisateur],
        ])
        ->where('data', 'like', '%"id_tache":'.$tache->id_tache.'%')
        ->exists();

        if (!$notifExist) {
            \App\Models\Notification::create([
                'projet_id' => $id_projet,
                'type' => 'tache_retard',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $tache->id_utilisateur,
                'data' => "La tâche '{$tache->titre}' est en retard dans le projet '{$projet->nom}'.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    return redirect()->route('tache.index', [
        'id_projet' => $id_projet,
        'sprint_id' => $tache->id_sprint
    ])->with('success', 'Tâche mise à jour');
}



    public function delete($id_projet, $id_tache)
    {
        $tache = Tache::findOrFail($id_tache);
        $this->verifAccessTacheOuChef($id_projet, $tache);
        $sprintId = $tache->id_sprint;
        $tache->delete();

        return redirect()->route('tache.index', ['id_projet' => $id_projet, 'sprint_id' => $sprintId])
            ->with('success', 'Tâche supprimée');
    }

public function updateStatus(Request $request, $id_projet, $id_tache)
{
    // Validation du statut
    $validated = $request->validate([
        'statut' => 'required|in:à faire,en cours,terminée'
    ]);

    try {
        $tache = Tache::findOrFail($id_tache);

        // Vérifier que la tâche appartient au projet
        if ($tache->id_projet != $id_projet) {
            return response()->json(['success' => false, 'message' => 'Tâche non trouvée'], 404);
        }

        // Mettre à jour le statut
        $tache->statut = $validated['statut'];
        $tache->save();

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'statut' => $tache->statut
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
        ], 500);
    }
}

}

<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\Tache;
use App\Models\Epic;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SprintController extends Controller
{
    public function index($projetId)
    {
        $projet = Projet::findOrFail($projetId);

        $sprints = Sprint::where('id_projet', $projetId)->get();

        // Pour chaque sprint, récupérer les epics et leurs tâches associées à ce sprint
        $sprintsDetails = $sprints->map(function($sprint) {
            $epics = Epic::where('id_projet', $sprint->id_projet)->get();
            $epicsWithTaches = $epics->map(function($epic) use ($sprint) {

                $taches = Tache::where('id_epic', $epic->id_epic)
                    ->where('id_sprint', $sprint->id_sprint)
                    ->get();

                return [
                    'epic' => $epic,
                    'taches' => $taches
                ];
            });

            return [
                'sprint' => $sprint,
                'epics' => $epicsWithTaches
            ];
        });

        return view('sprint.index', compact('projet','sprints', 'sprintsDetails'));
    }
    public function getSprintDetails($id)
    {
        $sprint = Sprint::findOrFail($id);

        $epics = Epic::where('id_projet', $sprint->id_projet)->get();

        // Epics + tâches liées AU sprint seulement
        $epicsWithTaches = $epics->map(function($epic) use ($sprint) {
            $taches = Tache::where('id_epic', $epic->id_epic)
                ->where('id_sprint', $sprint->id_sprint)
                ->get();

            return [
                'epic' => $epic->titre,
                'taches' => $taches->map(function($t){
                    return [
                        'titre' => $t->titre,
                        'statut' => $t->statut,
                    ];
                })
            ];
        });

        return response()->json([
            'nom' => $sprint->nom,
            'objectif' => $sprint->objectif,
            'epics' => $epicsWithTaches,
        ]);
    }



    // Formulaire de création (affiche uniquement les projets de l'utilisateur)
    public function create($projetId)
    {
        $projet = Projet::where('id_projet', $projetId)
            ->where('chef_id', Auth::id())
            ->firstOrFail();

        return view('sprint.create', compact('projet'));
    }



    // Création du sprint et association au projet choisi
    public function store(Request $request, $projetId)
    {
        $projet = Projet::where('id_projet', $projetId)
            ->where('chef_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
            'objectif' => 'nullable|string',
        ]);

        $sprint = new Sprint($validated);
        $sprint->id_projet = $projet->id_projet;
        $sprint->save();

        return redirect()->route('projet.sprints.index', $projetId)
            ->with('success', 'Sprint créé avec succès.');
    }



    // Affichage d’un sprint précis
    public function show(Sprint $sprint)
    {
        $this->authorizeSprint($sprint);
        $taches = $sprint->taches;
        return view('sprint.show', compact('sprint', 'taches'));
    }


    // Détacher une tâche d’un sprint
    public function removeTache(Sprint $sprint, Tache $tache)
    {
        $this->authorizeSprint($sprint);
        if ($tache->id_sprint == $sprint->id_sprint) {
            $tache->update(['id_sprint' => null]);
        }
        return back()->with('success', 'Tâche retirée du sprint.');
    }

    // Vérifie si le sprint appartient à un projet de l’utilisateur connecté
    private function authorizeSprint(Sprint $sprint)
    {
        if ($sprint->projet->chef_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à ce sprint.');
        }
    }

    public function sprintDetails($id)
    {
        $sprint = Sprint::with('epics.taches')
            ->findOrFail($id);

        return response()->json([
            'nom' => $sprint->nom,
            'objectif' => $sprint->objectif,
            'route' => route('tache.index', ['projet' => $sprint->projet_id, 'sprint_id' => $sprint->id_sprint]),
        ]);
    }


}

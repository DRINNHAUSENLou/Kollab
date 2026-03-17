<?php

namespace App\Http\Controllers;

use App\Models\Epic;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EpicController extends Controller
{
    // Affiche tous les epics d’un projet
    public function index($id_projet)
    {
        $projet = Projet::with('epics')->findOrFail($id_projet);

        // Seul le chef du projet peut gérer les epics
        if (Auth::id() !== $projet->chef_id) {
            abort(403, "Vous n'êtes pas autorisé à voir ces epics.");
        }

        return view('epic.index', compact('projet'));
    }

    // Formulaire de création d’un epic
    public function create($id_projet, Request $request)
    {
        $projet = Projet::findOrFail($id_projet);

        if (Auth::id() !== $projet->chef_id) {
            abort(403, "Vous n'êtes pas autorisé à ajouter un epic à ce projet.");
        }

        // Récupérer le sprint_id passé en paramètre (s'il existe)
        $sprintActuelId = $request->get('sprint_id');

        return view('epic.create', compact('projet', 'sprintActuelId'));
    }


    // Enregistrer un nouvel epic
    public function store(Request $request, $id_projet)
    {
        $projet = Projet::findOrFail($id_projet);

        if (Auth::id() !== $projet->chef_id) {
            abort(403, "Vous n'êtes pas autorisé à créer un epic dans ce projet.");
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|in:basse,moyenne,haute',
        ]);

        Epic::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'priorite' => $validated['priorite'],
            'id_projet' => $projet->id_projet,
        ]);

        // Rediriger vers le Kanban avec le sprint_id s'il existe
        $sprintId = $request->get('sprint_id');

        if ($sprintId) {
            return redirect()->route('tache.index', ['id_projet' => $projet->id_projet, 'sprint_id' => $sprintId])
                ->with('success', 'Epic ajouté avec succès !');
        }

        return redirect()->route('tache.index', $projet->id_projet)
            ->with('success', 'Epic ajouté avec succès !');
    }


    // Formulaire d’édition
    public function edit($id_projet, $id_epic)
    {
        $projet = Projet::findOrFail($id_projet);
        $epic = Epic::findOrFail($id_epic);

        if (Auth::id() !== $projet->chef_id) {
            abort(403, "Vous n'êtes pas autorisé à modifier cet epic.");
        }

        return view('epic.edit', compact('projet', 'epic'));
    }

    // Mettre à jour un epic
    public function update(Request $request, $id_projet, $id_epic)
    {
        $projet = Projet::findOrFail($id_projet);
        $epic = Epic::findOrFail($id_epic);

        if (Auth::id() !== $projet->chef_id) {
            abort(403, "Vous n'êtes pas autorisé à modifier cet epic.");
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|in:basse,moyenne,haute',
            'statut' => 'required|in:a_faire,en_cours,fini',
        ]);

        $epic->update($validated);

        // Rediriger vers le Kanban avec le sprint_id s'il existe
        $sprintId = $request->get('sprint_id');

        if ($sprintId) {
            return redirect()->route('tache.index', ['id_projet' => $id_projet, 'sprint_id' => $sprintId])
                ->with('success', 'Epic modifié avec succès !');
        }

        return redirect()->route('tache.index', $id_projet)
            ->with('success', 'Epic modifié avec succès !');
    }


    // Suppression d’un epic (on utilise delete comme toi)
    public function delete($id_projet, $id_epic, Request $request)
    {
        $projet = Projet::findOrFail($id_projet);
        $epic = Epic::findOrFail($id_epic);

        if (Auth::id() !== $projet->chef_id) {
            abort(403, "Vous n'êtes pas autorisé à supprimer cet epic.");
        }

        $epic->delete();

        // Rediriger vers le Kanban avec le sprint_id s'il existe
        $sprintId = $request->get('sprint_id');

        if ($sprintId) {
            return redirect()->route('tache.index', ['id_projet' => $id_projet, 'sprint_id' => $sprintId])
                ->with('success', 'Epic supprimé avec succès !');
        }

        return redirect()->route('tache.index', $id_projet)
            ->with('success', 'Epic supprimé avec succès !');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\MembreProjet;
use App\Models\Projet;
use App\Models\User;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembreProjetController extends Controller
{
    public function ajouter(Request $request, $projet)
    {
        $projet = Projet::findOrFail($projet);
        $user = Auth::user();
        if ($user->id !== $projet->chef_id) {
            abort(403, "Vous n'êtes pas autorisé à ajouter un membre.");
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:editeur,lecteur',
        ]);

        $existe = MembreProjet::where('id_projet', $projet->id_projet)
            ->where('id_utilisateur', $request->user_id)
            ->exists();

        if ($existe) {
            return back()->with('error', "Cet utilisateur est déjà membre du projet !");
        }

        MembreProjet::create([
            'id_projet' => $projet->id_projet,
            'id_utilisateur' => $request->user_id,
            'role' => $request->role,
            'date_ajout' => now(),
        ]);

        \App\Models\Notification::create([
            'projet_id' => $projet->id_projet,
            'type' => 'membre_ajoute',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $request->user_id,
            'data' => "Tu as été ajouté au projet '{$projet->nom}' en tant que {$request->role}.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', "Membre ajouté avec succès !");
    }

    public function retirer($projet, $membre)
    {
        $projetObj = Projet::findOrFail($projet);

        \DB::table('membre_projet')
            ->where('id_projet', $projet)
            ->where('id_utilisateur', $membre)
            ->delete();

        Tache::where('id_projet', $projet)
            ->where('id_utilisateur', $membre)
            ->update(['id_utilisateur' => null]);

        \App\Models\Notification::create([
            'projet_id' => $projet,
            'type' => 'membre_retiré',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $membre,
            'data' => "Tu as été retiré du projet {$projetObj->nom}.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Membre retiré du projet et désassigné de ses tâches.');
    }

public function changerRole(Request $request, $projet, $membre)
{
    $request->validate([
        'role' => 'required|in:editeur,lecteur',
    ]);

    $membreProjet = MembreProjet::where('id_projet', $projet)
        ->where('id_utilisateur', $membre)
        ->firstOrFail();

    $ancienRole = $membreProjet->role;

    $membreProjet->update([
        'role' => $request->role
    ]);

    // Si passage de éditeur à lecteur, désassigner de toutes les tâches
    if ($ancienRole === 'editeur' && $request->role === 'lecteur') {
        $tachesDesassignees = Tache::where('id_projet', $projet)
            ->where('id_utilisateur', $membre)
            ->get();

        Tache::where('id_projet', $projet)
            ->where('id_utilisateur', $membre)
            ->update(['id_utilisateur' => null]);

        // Notification pour chaque tâche désassignée
        foreach ($tachesDesassignees as $tache) {
            \App\Models\Notification::create([
                'projet_id' => $projet,
                'type' => 'tache_unassigned',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $membre,
                'data' => "La tâche '{$tache->titre}' ne t'est plus assignée suite au changement de rôle.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    $projetObj = Projet::findOrFail($projet);
    \App\Models\Notification::create([
        'projet_id' => $projet,
        'type' => 'role_modifié',
        'notifiable_type' => 'App\Models\User',
        'notifiable_id' => $membre,
        'data' => "Ton rôle sur le projet '{$projetObj->nom}' a été changé de '$ancienRole' à '{$request->role}'.",
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'Le rôle du membre a été modifié.');
}




}


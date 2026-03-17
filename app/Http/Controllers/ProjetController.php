<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\MembreProjet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    // Affichage des projets : tous les projets dont l'utilisateur est chef
    public function index()
    {
        $user = Auth::user();

        $projets = Projet::where('chef_id', $user->id)
                        ->orderBy('date_creation', 'desc')
                        ->get();
        $projetsPartages = Projet::whereHas('membres', function($query) use ($user) {
                $query->where('id_utilisateur', $user->id);
            })->where('chef_id', '!=', $user->id)
            ->get();
        return view('accueil_projet', compact('projets', 'projetsPartages'));
    }

    // Formulaire de création : accessible à tous les utilisateurs connectés
    public function create()
    {
        return view('projet.create');
    }

    // Création d'un projet : l'utilisateur qui crée devient automatiquement chef
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin_prevue' => 'nullable|date',
            'priorite' => 'required|in:basse,moyenne,haute',
        ]);

        if ($request->filled('date_debut')) {
            $validated['date_debut'] = Carbon::parse($request->date_debut);
        }
        $validated['chef_id'] = $user->id;
        $validated['date_creation'] = now();

        // Calcul automatique du statut
        $validated['statut'] = Projet::calculerStatut($validated['date_debut'], $validated['date_fin_prevue'] ?? null);

        $projet = Projet::create($validated);

        MembreProjet::create([
            'id_projet' => $projet->id_projet,
            'id_utilisateur' => $user->id,
            'role' => 'chef',
            'date_ajout' => now(),
        ]);

        return redirect()->route('projet.index')->with('success', 'Projet créé avec succès !');
    }

    // Détails d'un projet
    public function show($id)
    {
        $projet = Projet::findOrFail($id);

        // Mise à jour du statut en base à l'affichage
        $statut = Projet::calculerStatut($projet->date_debut, $projet->date_fin_prevue);
        if ($projet->statut !== $statut) {
            $projet->statut = $statut;
            $projet->save();
        }

        $membresIds = MembreProjet::where('id_projet', $projet->id_projet)
            ->pluck('id_utilisateur')
            ->toArray();

        $users = \App\Models\User::whereNotIn('id', $membresIds)
            ->get(['id', 'name']);

        $tachesTerminees = $projet->taches()
            ->where('statut', 'terminée')
            ->whereNotNull('date_fin_prevue')
            ->orderBy('date_fin_prevue')
            ->get();

        $tachesLate = $projet->taches()
            ->whereNotNull('date_fin_prevue')
            ->where('date_fin_prevue', '<', now())
            ->where('statut', '!=', 'terminée')
            ->count();

        $debut = Carbon::parse($projet->date_debut)->startOfWeek();
        $fin = $projet->date_fin_prevue
            ? Carbon::parse($projet->date_fin_prevue)->endOfWeek()
            : Carbon::now()->endOfWeek();

        $courbe_labels = [];
        $courbe_cumul = [];
        $total = 0;
        $date = $debut->copy();

        while ($date <= $fin) {
            $semaine = $date->format('d/m/y');
            $count = $tachesTerminees->filter(function ($t) use ($date) {
                return Carbon::parse($t->date_fin_prevue)->isSameWeek($date);
            })->count();
            $total += $count;
            $courbe_labels[] = $semaine;
            $courbe_cumul[] = $total;
            $date->addWeek();
        }

        return view('projet.show', compact('projet', 'users', 'courbe_labels', 'courbe_cumul', 'tachesLate'));
    }
    
    public function membres()
    {
        return $this->belongsToMany(User::class, 'membre_projet', 'id_projet', 'id_utilisateur')->withTimestamps()->orderBy('membre_projet.created_at');
    }

}

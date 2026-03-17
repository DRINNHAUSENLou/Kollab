<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $table = 'projet';
    protected $primaryKey = 'id_projet';
    public $timestamps = false;

    protected $casts = [
        'date_debut' => 'datetime',
        'date_creation' => 'datetime',
        'date_fin_prevue' => 'datetime',
        'chef_id' => 'int',
    ];

    protected $fillable = [
        'nom',
        'date_debut',
        'date_creation',
        'date_fin_prevue',
        'description',
        'statut',
        'priorite',
        'chef_id',
    ];

        public static function calculerStatut($dateDebut, $dateFinPrevue)
    {
        $now = Carbon::now();
        $dateDebut = Carbon::parse($dateDebut);
        $dateFinPrevue = $dateFinPrevue ? Carbon::parse($dateFinPrevue) : null;

        if ($now->lt($dateDebut)) {
            return 'en attente';
        } elseif ($dateFinPrevue && $now->gt($dateFinPrevue)) {
            return 'terminé';
        } else {
            return 'en cours';
        }
    }

    // --- Relations ---

    // Chef du projet
    public function user()
    {
        return $this->belongsTo(User::class, 'chef_id');
    }

    // Epics liés au projet
    public function epics()
    {
        return $this->hasMany(Epic::class, 'id_projet', 'id_projet');
    }

    // Tâches liées au projet
    public function taches()
    {
        return $this->hasMany(Tache::class, 'id_projet', 'id_projet');
    }

    public function membres()
    {
        return $this->hasMany(MembreProjet::class, 'id_projet', 'id_projet')
        ->orderBy('date_ajout');
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class, 'id_projet', 'id_projet');
    }
    public function membresListe()
    {
        return $this->belongsToMany(User::class, 'membre_projet', 'id_projet', 'id_utilisateur')
            ->orderBy('membre_projet.date_ajout');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'projet_id', 'id_projet');
    }


}

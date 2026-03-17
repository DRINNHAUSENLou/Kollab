<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tache
 *
 * @property int $id_tache
 * @property string $titre
 * @property string|null $description
 * @property string $statut
 * @property string $priorite
 * @property Carbon $date_creation
 * @property Carbon|null $date_fin_prevue
 * @property int $id_projet
 * @property int $id_epic
 * @property int $id_sprint
 * @property int|null $id_utilisateur
 *
 * @property Epic $epic
 *
 * @package App\Models
 */
class Tache extends Model
{
    protected $table = 'tache';
    protected $primaryKey = 'id_tache';
    public $timestamps = false;

    protected $casts = [
        'id_projet' => 'int',
        'id_epic' => 'int',
        'id_sprint' => 'int',
        'id_utilisateur' => 'int',
        'date_creation' => 'datetime',
        'date_debut' => 'datetime',
        'date_fin_prevue' => 'datetime',
    ];

    protected $fillable = [
        'titre',
        'description',
        'statut',
        'priorite',
        'date_creation',
        'date_debut',
        'date_fin_prevue',
        'id_projet',
        'id_epic',
        'id_sprint',
        'id_utilisateur',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'id_projet', 'id_projet');
    }

    public function epic()
    {
        return $this->belongsTo(Epic::class, 'id_epic', 'id_epic');
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class, 'id_sprint', 'id_sprint');
    }
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

}

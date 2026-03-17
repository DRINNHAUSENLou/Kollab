<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sprint
 *
 * @property int $id_sprint
 * @property string $nom
 * @property int $id_projet
 * @property Carbon|null $date_debut
 * @property Carbon|null $date_fin
 * @property string|null $objectif
 *
 * @property Collection|EpicSprint[] $epic_sprints
 *
 * @package App\Models
 */
class Sprint extends Model
{
    protected $table = 'sprint';
    protected $primaryKey = 'id_sprint';
    public $timestamps = false;

    protected $casts = [
        'id_projet' => 'int',
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    protected $fillable = [
        'nom',
        'id_projet',
        'date_debut',
        'date_fin',
        'objectif',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'id_projet', 'id_projet');
    }

    public function taches()
    {
        return $this->hasMany(Tache::class, 'id_sprint', 'id_sprint');
    }

    public function epic_sprints()
    {
        return $this->hasMany(EpicSprint::class, 'id_sprint', 'id_sprint');
    }
}

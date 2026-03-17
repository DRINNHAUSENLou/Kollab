<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Epic
 *
 * @property int $id_epic
 * @property string $titre
 * @property string|null $description
 * @property string $priorite
 * @property string $statut
 * @property int $id_projet
 *
 * @property Projet $projet
 * @property Collection|Tache[] $taches
 *
 * @package App\Models
 */
class Epic extends Model
{
	protected $table = 'epic';
	protected $primaryKey = 'id_epic';
	public $timestamps = false;

	protected $casts = [
		'id_projet' => 'int'
	];

	protected $fillable = [
		'titre',
		'description',
		'priorite',
		'statut',
		'id_projet'
	];

	public function projet()
	{
		return $this->belongsTo(Projet::class, 'id_projet');
	}

    public function taches() {
        return $this->hasMany(Tache::class, 'id_epic', 'id_epic');
    }

}

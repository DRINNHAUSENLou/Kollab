<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MembreProjet
 *
 * @property int $id_projet
 * @property int $id_utilisateur
 * @property Carbon $date_ajout
 *
 * @property User $user
 *
 * @package App\Models
 */
class MembreProjet extends Model
{
    protected $table = 'membre_projet';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;

    protected $casts = [
        'id_projet' => 'int',
        'id_utilisateur' => 'int',
        'date_ajout' => 'datetime'
    ];

    protected $fillable = [
        'id_projet',
        'id_utilisateur',
        'date_ajout',
        'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('id_projet', '=', $this->getAttribute('id_projet'))
            ->where('id_utilisateur', '=', $this->getAttribute('id_utilisateur'));

        return $query;
    }
}

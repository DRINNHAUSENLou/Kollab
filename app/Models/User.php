<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|MembreProjet[] $membre_projets
 * @property Collection|Projet[] $projets
 *
 * @package App\Models
 */
class User extends Authenticatable

{
	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
        'role',
        'couleur',
	];

	public function membre_projets()
	{
		return $this->hasMany(MembreProjet::class, 'id_utilisateur');
	}

	public function projets()
	{
		return $this->hasMany(Projet::class, 'chef_id');
	}

    public function taches()
    {
        return $this->hasMany(Tache::class, 'id_utilisateur');
    }

}

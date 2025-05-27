<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property string|null $document
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Student[] $students
 * @property Collection|Teacher[] $teachers
 * @property Collection|Coordinator[] $coordinators
 * @property Collection|Form[] $forms
 *
 * @package App\Models
 */
class User extends Model
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
		'role',
		'remember_token',
        'document'
	];

	public function students()
	{
		return $this->hasMany(Student::class);
	}

	public function teachers()
	{
		return $this->hasMany(Teacher::class);
	}

	public function coordinators()
	{
		return $this->hasMany(Coordinator::class);
	}

	public function forms()
	{
		return $this->hasMany(Form::class, 'validated_by');
	}
}

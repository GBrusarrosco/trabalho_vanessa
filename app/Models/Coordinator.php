<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Coordinator
 * 
 * @property int $id
 * @property int $user_id
 * @property string $departamento
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Coordinator extends Model
{
	protected $table = 'coordinators';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'departamento'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

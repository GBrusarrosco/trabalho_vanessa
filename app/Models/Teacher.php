<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Teacher
 * 
 * @property int $id
 * @property int $user_id
 * @property string $area
 * @property string|null $observacoes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Teacher extends Model
{
	protected $table = 'teachers';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'area',
		'observacoes'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

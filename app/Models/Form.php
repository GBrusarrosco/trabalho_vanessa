<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Form
 * 
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property bool $is_validated
 * @property int|null $validated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|Question[] $questions
 * @property Collection|Student[] $students
 *
 * @package App\Models
 */
class Form extends Model
{
	protected $table = 'forms';

	protected $casts = [
		'is_validated' => 'bool',
		'validated_by' => 'int'
	];

	protected $fillable = [
		'title',
		'description',
		'is_validated',
		'validated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'validated_by');
	}

	public function questions()
	{
		return $this->hasMany(Question::class);
	}

	public function students()
	{
		return $this->belongsToMany(Student::class, 'student_form')
					->withPivot('id')
					->withTimestamps();
	}
}

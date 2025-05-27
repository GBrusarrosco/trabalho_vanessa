<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * 
 * @property int $id
 * @property int $student_id
 * @property int $question_id
 * @property string $answer_text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Student $student
 * @property Question $question
 *
 * @package App\Models
 */
class Answer extends Model
{
	protected $table = 'answers';

	protected $casts = [
		'student_id' => 'int',
		'question_id' => 'int'
	];

	protected $fillable = [
		'student_id',
		'question_id',
		'answer_text'
	];

	public function student()
	{
		return $this->belongsTo(Student::class);
	}

	public function question()
	{
		return $this->belongsTo(Question::class);
	}
}

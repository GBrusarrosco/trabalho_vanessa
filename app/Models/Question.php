<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * 
 * @property int $id
 * @property int $form_id
 * @property string $question_text
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Form $form
 * @property Collection|Answer[] $answers
 *
 * @package App\Models
 */
class Question extends Model
{
	protected $table = 'questions';

	protected $casts = [
		'form_id' => 'int'
	];

	protected $fillable = [
		'form_id',
		'question_text',
		'type'
	];

	public function form()
	{
		return $this->belongsTo(Form::class);
	}

	public function answers()
	{
		return $this->hasMany(Answer::class);
	}
}

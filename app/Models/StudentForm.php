<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentForm
 * 
 * @property int $id
 * @property int $student_id
 * @property int $form_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Student $student
 * @property Form $form
 *
 * @package App\Models
 */
class StudentForm extends Model
{
	protected $table = 'student_form';

	protected $casts = [
		'student_id' => 'int',
		'form_id' => 'int'
	];

	protected $fillable = [
		'student_id',
		'form_id'
	];

	public function student()
	{
		return $this->belongsTo(Student::class);
	}

	public function form()
	{
		return $this->belongsTo(Form::class);
	}
}

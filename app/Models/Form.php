<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'forms';

    protected $casts = [
        'validated_by' => 'int',
        'creator_user_id' => 'int',
    ];

    protected $fillable = [
        'title',
        'description',
        'turma',
        'ano_letivo',
        'status', // Adicionado
        'rejection_reason', // Adicionado
        'validated_by',
        'creator_user_id',
    ];

    // Relações...
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    public function validator() // Mantendo o nome 'validator' para quem validou/aprovou
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

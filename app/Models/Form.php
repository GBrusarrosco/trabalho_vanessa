<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'forms';

    protected $casts = [
        'is_validated' => 'bool',
        'validated_by' => 'int',
        'creator_user_id' => 'int', // Adicionar cast
    ];

    protected $fillable = [
        'title',
        'description',
        'is_validated',
        'validated_by',
        'creator_user_id', // Adicionar aos fillable
    ];

    // Relação com o usuário que validou (já existente)
    public function validator() // Renomear de user para validator para clareza
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // NOVA RELAÇÃO: Usuário que criou o formulário
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
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

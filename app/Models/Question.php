<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $casts = [
        'form_id' => 'int',
        'options' => 'array', // Adicionar cast para array (Laravel trata JSON automaticamente)
    ];

    protected $fillable = [
        'form_id',
        'question_text',
        'type',
        'options', // Adicionar aos fillable
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

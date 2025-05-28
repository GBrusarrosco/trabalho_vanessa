<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'remember_token',
        'document',
    ];

    // Relações

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function coordinator()
    {
        return $this->hasOne(Coordinator::class);
    }


    public function forms()
    {
        return $this->hasMany(Form::class, 'validated_by');
    }
}

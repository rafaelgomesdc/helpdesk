<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'security_question', 'security_answer',
        'status', 'profile', 'sector_id', 'cargo_id', 'phone',
    ];

    protected $hidden = ['password', 'security_answer', 'remember_token'];

    public function setSecurityAnswerAttribute($value)
    {
        $this->attributes['security_answer'] = Hash::make(strtolower(trim($value)));
    }

    public function verifySecurityAnswer($plainAnswer)
    {
        return Hash::check(strtolower(trim($plainAnswer)), $this->security_answer);
    }
}

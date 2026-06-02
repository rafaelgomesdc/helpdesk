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
        'status', 'profile', 'sector_id', 'cargo_id', 'phone'
    ];

    protected $hidden = ['password', 'security_answer', 'remember_token'];

    // Ao gravar a resposta secreta, já criptografa
    public function setSecurityAnswerAttribute($value)
    {
        $this->attributes['security_answer'] = Hash::make($value);
    }

    // Verifica se a resposta está correta
    public function verifySecurityAnswer($plainAnswer)
    {
        return Hash::check($plainAnswer, $this->security_answer);
    }
}
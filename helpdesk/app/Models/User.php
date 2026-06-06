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
        'status', 'profile', 'phone', 'address', 'setor_id', 'cargo_id', 'role_id',
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

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->profile === 'Admin';
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->role?->permissions->contains('name', $permission) ?? false;
    }
}

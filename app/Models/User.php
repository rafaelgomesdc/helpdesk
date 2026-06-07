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
        'status', 'profile', 'role', 'phone', 'address', 'setor_id', 'cargo_id', 'role_id',
    ];

    protected $hidden = ['password', 'security_answer', 'remember_token'];

    protected static function booted(): void
    {
        static::saving(function (User $user) {
            if ($user->isDirty('profile') || ! $user->role) {
                $user->role = self::profileToRoleEnum($user->profile);
            }
        });
    }

    public static function profileToRoleEnum(?string $profile): string
    {
        return match ($profile) {
            'Admin' => 'admin',
            'Técnico' => 'technician',
            default => 'user',
        };
    }

    public function setSecurityAnswerAttribute($value)
    {
        if ($value === null || $value === '') {
            return;
        }

        $this->attributes['security_answer'] = Hash::make(strtolower(trim($value)));
    }

    public function verifySecurityAnswer($plainAnswer)
    {
        if (! $this->security_answer) {
            return false;
        }

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

    public function accessRole()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function isAdmin(): bool
    {
        return $this->profile === 'Admin';
    }

    public function isPending(): bool
    {
        return $this->status === 'Pendente';
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->accessRole?->permissions->contains('name', $permission) ?? false;
    }
}

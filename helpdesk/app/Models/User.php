<?php

// =============================================================================
//  MODEL — USUÁRIO DO SISTEMA
//  Responsável: Dupla 1 — Vitória e Camila
//  Módulo: Usuários e Autenticação
// =============================================================================

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    // -------------------------------------------------------------------------
    // Campos que podem ser preenchidos em massa
    // -------------------------------------------------------------------------
    protected $fillable = [
        'name', 'email', 'email_pessoal', 'password', 'security_question', 'security_answer',
        'status', 'profile', 'phone', 'address', 'setor_id', 'cargo_id',
        'role_id', 'contato',
    ];

    // Campos ocultados nas respostas JSON (nunca expõe senha ou resposta de segurança)
    protected $hidden = ['password', 'security_answer', 'remember_token'];

    // -------------------------------------------------------------------------
    // Converte o perfil legível (Admin / Técnico / Usuário) para o enum interno
    // usado nas verificações de autorização do sistema
    // -------------------------------------------------------------------------
    public static function profileToRoleEnum(?string $profile): string
    {
        return match ($profile) {
            'Admin'   => 'admin',
            'Técnico' => 'technician',
            default   => 'user',
        };
    }

    // -------------------------------------------------------------------------
    // Mutator: armazena a resposta de segurança sempre como hash (bcrypt)
    // Ignora valores vazios para não sobrescrever a resposta existente
    // -------------------------------------------------------------------------
    public function setSecurityAnswerAttribute($value)
    {
        if ($value === null || $value === '') {
            return;
        }

        $this->attributes['security_answer'] = Hash::make(strtolower(trim($value)));
    }

    // -------------------------------------------------------------------------
    // Verifica se a resposta de segurança fornecida bate com o hash armazenado
    // A comparação ignora maiúsculas/minúsculas e espaços extras
    // -------------------------------------------------------------------------
    public function verifySecurityAnswer($plainAnswer)
    {
        if (! $this->security_answer) {
            return false;
        }

        return Hash::check(strtolower(trim($plainAnswer)), $this->security_answer);
    }

    // =========================================================================
    // RELACIONAMENTOS
    // =========================================================================

    // Setor ao qual o usuário pertence
    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    // Cargo ocupado pelo usuário dentro do setor
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    // Perfil de acesso (Role) atribuído ao usuário para controle de permissões
    public function accessRole()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // =========================================================================
    // HELPERS DE VERIFICAÇÃO
    // =========================================================================

    // Verifica se o usuário possui perfil de administrador
    public function isAdmin(): bool
    {
        return $this->profile === 'Admin';
    }

    // Verifica se o cadastro do usuário está aguardando aprovação
    public function isPending(): bool
    {
        return $this->status === 'Pendente';
    }

    // Verifica se o usuário possui uma permissão específica pelo nome
    // Administradores têm acesso irrestrito a todas as permissões
    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->accessRole?->permissions->contains('name', $permission) ?? false;
    }
}

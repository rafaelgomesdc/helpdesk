<?php

// =============================================================================
//  MODEL — PERFIL DE ACESSO (ROLE)
//  Responsável: Dupla 4 — Gabriel e Murilo
//  Módulo: Categorias, Prioridades, Dashboard e Base
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    // -------------------------------------------------------------------------
    // Campos que podem ser preenchidos em massa
    // -------------------------------------------------------------------------
    protected $fillable = ['name', 'description'];

    // =========================================================================
    // RELACIONAMENTOS
    // =========================================================================

    // Permissões associadas a este perfil (tabela pivô: permission_role)
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}

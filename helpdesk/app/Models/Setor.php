<?php

// =============================================================================
//  MODEL — SETOR DA ORGANIZAÇÃO
//  Responsável: Dupla 3 — Paulo e Vitor
//  Módulo: Gerenciamento e Painel Técnico
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setor extends Model
{
    protected $table = 'setores';

    // -------------------------------------------------------------------------
    // Campos que podem ser preenchidos em massa
    // -------------------------------------------------------------------------
    protected $fillable = ['nome', 'descricao'];

    // =========================================================================
    // RELACIONAMENTOS
    // =========================================================================

    // Cargos pertencentes a este setor
    public function cargos(): HasMany
    {
        return $this->hasMany(Cargo::class);
    }

    // Usuários vinculados a este setor
    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

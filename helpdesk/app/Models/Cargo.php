<?php

// =============================================================================
//  MODEL — CARGO DO USUÁRIO
//  Responsável: Dupla 3 — Paulo e Vitor
//  Módulo: Gerenciamento e Painel Técnico
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends Model
{
    // -------------------------------------------------------------------------
    // Campos que podem ser preenchidos em massa
    // -------------------------------------------------------------------------
    protected $fillable = ['nome', 'setor_id', 'descricao'];

    // =========================================================================
    // RELACIONAMENTOS
    // =========================================================================

    // Setor ao qual este cargo pertence (pode ser nulo)
    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }

    // Usuários que ocupam este cargo
    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

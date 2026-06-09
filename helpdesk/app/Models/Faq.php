<?php

// =============================================================================
//  MODEL — FAQ (PERGUNTA FREQUENTE)
//  Responsável: Dupla 2 — Gustavo e Rafael
//  Módulo: Abertura e Comunicação
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    protected $table = 'faqs';

    // -------------------------------------------------------------------------
    // Campos que podem ser preenchidos em massa
    // -------------------------------------------------------------------------
    protected $fillable = ['pergunta', 'resposta', 'categoria_id'];

    // =========================================================================
    // RELACIONAMENTOS
    // =========================================================================

    // Categoria à qual esta FAQ está associada (opcional)
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}

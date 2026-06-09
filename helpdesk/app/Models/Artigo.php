<?php

// =============================================================================
//  MODEL — ARTIGO DA BASE DE CONHECIMENTO
//  Responsável: Dupla 2 — Gustavo e Rafael
//  Módulo: Abertura e Comunicação
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artigo extends Model
{
    protected $table = 'artigos';

    // -------------------------------------------------------------------------
    // Campos que podem ser preenchidos em massa
    // -------------------------------------------------------------------------
    protected $fillable = ['titulo', 'conteudo', 'categoria_id', 'author_id'];

    // =========================================================================
    // RELACIONAMENTOS
    // =========================================================================

    // Categoria à qual o artigo está associado (opcional)
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    // Usuário (Técnico ou Admin) que redigiu o artigo
    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

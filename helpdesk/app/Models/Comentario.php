<?php

// =============================================================================
//  MODEL — COMENTÁRIO DE CHAMADO
//  Responsável: Dupla 2 — Gustavo e Rafael
//  Módulo: Abertura e Comunicação
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    protected $table = 'comentarios';

    // -------------------------------------------------------------------------
    // Campos que podem ser preenchidos em massa
    // -------------------------------------------------------------------------
    protected $fillable = ['ticket_id', 'user_id', 'conteudo'];

    // =========================================================================
    // RELACIONAMENTOS
    // =========================================================================

    // Chamado ao qual este comentário pertence
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // Usuário (solicitante ou técnico) que fez o comentário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

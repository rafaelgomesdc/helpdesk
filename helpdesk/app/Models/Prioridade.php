<?php

// =============================================================================
//  MODEL — PRIORIDADE DE CHAMADOS
//  Responsável: Dupla 4 — Gabriel e Murilo
//  Módulo: Categorias, Prioridades, Dashboard e Base
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prioridade extends Model
{
    protected $table = 'prioridades';

    // -------------------------------------------------------------------------
    // Campos que podem ser preenchidos em massa
    // O campo "nivel" define a ordenação (1 = mais baixa, 10 = mais crítica)
    // O campo "cor" armazena a cor de exibição (ex: "red", "#FF0000")
    // -------------------------------------------------------------------------
    protected $fillable = ['nome', 'nivel', 'cor'];
}

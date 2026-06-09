<?php

// =============================================================================
//  MODEL — CHAMADO (TICKET)
//  Responsável: Dupla 2 — Gustavo e Rafael
//  Módulo: Abertura e Comunicação
// =============================================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    // -------------------------------------------------------------------------
    // Campos que podem ser preenchidos em massa
    // -------------------------------------------------------------------------
    protected $fillable = [
        'title', 'description', 'status', 'priority',
        'categoria_id', 'user_id', 'technician_id', 'solution', 'resolved_at',
    ];

    // =========================================================================
    // CONSTANTES DE MAPEAMENTO — STATUS E PRIORIDADE
    // =========================================================================

    // Rótulos em português para cada status do chamado
    public const STATUS_LABELS = [
        'open'        => 'Aberto',
        'in_progress' => 'Em andamento',
        'resolved'    => 'Resolvido',
        'closed'      => 'Fechado',
    ];

    // Rótulos em português para cada nível de prioridade
    public const PRIORITY_LABELS = [
        'low'      => 'Baixa',
        'medium'   => 'Média',
        'high'     => 'Alta',
        'critical' => 'Crítica',
    ];

    // =========================================================================
    // ACCESSORS — ATRIBUTOS CALCULADOS
    // =========================================================================

    // Retorna o rótulo legível do status atual do chamado
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    // Retorna o rótulo legível da prioridade atual do chamado
    public function getPriorityLabelAttribute(): string
    {
        return self::PRIORITY_LABELS[$this->priority] ?? $this->priority;
    }

    // =========================================================================
    // RELACIONAMENTOS
    // =========================================================================

    // Usuário solicitante que abriu o chamado
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Técnico responsável pelo atendimento do chamado
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    // Categoria à qual o chamado pertence
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Arquivos anexados ao chamado
    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }

    // Comentários adicionados ao chamado por solicitantes e técnicos
    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'ticket_id');
    }

    // Histórico de eventos do chamado (atribuições, status, soluções etc.)
    // Ordenado do mais recente para o mais antigo
    public function histories(): HasMany
    {
        return $this->hasMany(TicketHistory::class, 'ticket_id')->orderBy('created_at', 'desc');
    }
}

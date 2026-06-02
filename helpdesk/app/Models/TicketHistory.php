<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketHistory extends Model
{
    protected $fillable = ['ticket_id', 'user_id', 'action', 'description'];

    const ACTION_LABELS = [
        'assigned'            => 'Chamado assumido',
        'status_changed'      => 'Status alterado',
        'solution_registered' => 'Solução registrada',
        'comment_added'       => 'Comentário adicionado',
    ];

    const ACTION_ICONS = [
        'assigned'            => 'bi-person-check',
        'status_changed'      => 'bi-arrow-repeat',
        'solution_registered' => 'bi-check-circle',
        'comment_added'       => 'bi-chat',
    ];

    public function getActionLabelAttribute(): string
    {
        return self::ACTION_LABELS[$this->action] ?? $this->action;
    }

    public function getActionIconAttribute(): string
    {
        return self::ACTION_ICONS[$this->action] ?? 'bi-circle';
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

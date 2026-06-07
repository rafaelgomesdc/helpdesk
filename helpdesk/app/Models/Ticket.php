<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'title', 'description', 'status', 'priority',
        'categoria_id', 'user_id', 'technician_id', 'solution', 'resolved_at',
    ];

    public const STATUS_LABELS = [
        'open' => 'Aberto',
        'in_progress' => 'Em andamento',
        'resolved' => 'Resolvido',
        'closed' => 'Fechado',
    ];

    public const PRIORITY_LABELS = [
        'low' => 'Baixa',
        'medium' => 'Média',
        'high' => 'Alta',
        'critical' => 'Crítica',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::PRIORITY_LABELS[$this->priority] ?? $this->priority;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'ticket_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(TicketHistory::class, 'ticket_id')->orderBy('created_at', 'desc');
    }
}

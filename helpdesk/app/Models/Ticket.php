<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'title', 'description', 'status', 'priority',
        'user_id', 'technician_id', 'solution',
    ];

    const STATUS_LABELS = [
        'open'        => 'Aberto',
        'in_progress' => 'Em andamento',
        'resolved'    => 'Resolvido',
        'closed'      => 'Fechado',
    ];

    const PRIORITY_LABELS = [
        'low'      => 'Baixa',
        'medium'   => 'Média',
        'high'     => 'Alta',
        'critical' => 'Crítica',
    ];

    const STATUS_BADGE_CLASSES = [
        'open'        => 'bg-secondary',
        'in_progress' => 'bg-primary',
        'resolved'    => 'bg-success',
        'closed'      => 'bg-dark',
    ];

    const PRIORITY_BADGE_CLASSES = [
        'low'      => 'bg-success',
        'medium'   => 'bg-warning text-dark',
        'high'     => 'bg-danger',
        'critical' => 'bg-dark',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::PRIORITY_LABELS[$this->priority] ?? $this->priority;
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return self::STATUS_BADGE_CLASSES[$this->status] ?? 'bg-secondary';
    }

    public function getPriorityBadgeClassAttribute(): string
    {
        return self::PRIORITY_BADGE_CLASSES[$this->priority] ?? 'bg-secondary';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(TicketHistory::class)->orderBy('created_at', 'asc');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }
}

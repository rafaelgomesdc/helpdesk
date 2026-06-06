<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'categoria_id',
        'user_id',
        'technician_id',
        'solution',
        'resolved_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'ticket_id');
    }

    public function histories()
    {
        return $this->hasMany(TicketHistory::class, 'ticket_id');
    }
}
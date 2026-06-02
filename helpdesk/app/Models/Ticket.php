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

    public function histories()
    {
        return $this->hasMany(
            TicketHistory::class
        );
    }
}
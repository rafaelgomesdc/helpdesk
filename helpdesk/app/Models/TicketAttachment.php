<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    protected $fillable = [
        'ticket_id',
        'filename',
        'path',
        'size',
        'mime_type'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
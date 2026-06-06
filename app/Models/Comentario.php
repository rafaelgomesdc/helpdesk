<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    // Forçando o nome da tabela conforme o banco de dados
    protected $table = 'comentarios';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'conteudo'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chamados extends Model
{
    protected $fillable = [
        'setores',
        'cargo',
        //'data',
        'perfis',
        'usuarios'
    ];

    protected $casts = [
        'data' => 'datetime',
    ];
}

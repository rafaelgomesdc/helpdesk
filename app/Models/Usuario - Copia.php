<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Usuario extends Model
{
    protected $fillable = [
        'nome', 'email', 'senha', 'contato',
        'setor_id', 'cargo_id', 'perfil_id'
    ];

    // Para autenticação
    //protected $hidden = ['senha',];
    protected $hidden = ['senha'];

    public function getAuthPassword()
    {
        return $this->senha;
    }



    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class);
    }
}

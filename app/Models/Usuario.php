<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $fillable = ['nome', 'email', 'senha', 'contato', 'setor_id', 'cargo_id', 'perfil_id'];
    protected $hidden = ['senha'];

    // 🔹 ESSA FUNÇÃO É OBRIGATÓRIA PARA LOGAR
    public function getAuthPassword()
    {
        return $this->senha;
    }

    // 🔹 RELAÇÕES (NOME CORRETO DAS TABELAS)
    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class, 'setor_id');
    }

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfis'; // 🔹 NOME FORÇADO PARA DAR CERTO
    protected $fillable = ['nome', 'descricao'];
}
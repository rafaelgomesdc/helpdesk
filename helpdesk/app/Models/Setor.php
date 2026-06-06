<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setor extends Model
{
    protected $table = 'setores';

    protected $fillable = ['nome', 'descricao'];

    public function cargos(): HasMany
    {
        return $this->hasMany(Cargo::class);
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

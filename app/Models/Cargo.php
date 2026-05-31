<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends Model
{
    protected $table = 'cargos';
    
    protected $fillable = ['nome', 'descricao'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends Model
{
    protected $fillable = ['nome', 'setor_id', 'descricao'];

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

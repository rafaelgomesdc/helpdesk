<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artigo extends Model
{
    protected $table = 'artigos';

    protected $fillable = ['titulo', 'conteudo', 'categoria_id', 'author_id'];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

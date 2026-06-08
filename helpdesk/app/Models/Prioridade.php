<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prioridade extends Model
{
    protected $fillable = ['nome', 'nivel', 'cor'];
}

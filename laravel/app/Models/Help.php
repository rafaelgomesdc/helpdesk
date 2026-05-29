<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    public function up(): void
    {
        Schema::create('help', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('palestrante');
        $table->dateTime('data');
        $table->string('local');
        $table->text('descricao')->nullable();
        $table->timestamps();
        });
    }
}

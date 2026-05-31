<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prioridades', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->tinyInteger('nivel')->unsigned();
            $table->string('cor', 20)->default('#6c757d');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prioridades');
    }
};
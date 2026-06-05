<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // hash bcrypt
            $table->string('security_question')->nullable();
            $table->string('security_answer')->nullable(); // hash bcrypt
            $table->string('status')->default('Pendente'); // Ativo, Pendente, Rejeitado
            $table->string('profile')->default('Usuário'); // Admin, Técnico, Usuário
            $table->string('sector_id')->nullable();
            $table->string('cargo_id')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
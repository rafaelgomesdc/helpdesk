<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('security_question')->nullable();
            $table->string('security_answer')->nullable(); // será armazenado com hash
            $table->string('status')->default('Ativo');
            $table->string('profile')->default('Usuário');
            $table->string('sector_id')->nullable();
            $table->string('cargo_id')->nullable();
            $table->string('phone')->nullable();
            // Os campos padrão: name, email, password já existem
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'security_question',
                'security_answer',
                'status',
                'profile',
                'sector_id',
                'cargo_id',
                'phone'
            ]);
        });
    }
};
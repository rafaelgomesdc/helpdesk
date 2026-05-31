<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // AGORA VAMOS ALTERAR A TABELA, E NÃO CRIAR DO ZERO
        Schema::table('setores', function (Blueprint $table) {
            // Verifica se a coluna não existe antes de adicionar
            if (!Schema::hasColumn('setores', 'descricao')) {
                $table->text('descricao')->nullable();
            }
            $table->id();
            $table->string('nome', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('setores', function (Blueprint $table) {
            // $table->dropColumn('descricao');
        });
    }
};
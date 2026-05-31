<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Adiciona cargo_id SOMENTE SE NÃO EXISTIR
            if (!Schema::hasColumn('users', 'cargo_id')) {
                $table->foreignId('cargo_id')->nullable()->constrained();
            }

            // Adiciona setor_id SOMENTE SE NÃO EXISTIR
            if (!Schema::hasColumn('users', 'setor_id')) {
                $table->foreignId('setor_id')->nullable()->constrained();
            }

            // Adiciona telefone SOMENTE SE NÃO EXISTIR
            if (!Schema::hasColumn('users', 'telefone')) {
                $table->string('telefone', 20)->nullable();
            }

            // Adiciona endereco SOMENTE SE NÃO EXISTIR
            if (!Schema::hasColumn('users', 'endereco')) {
                $table->text('endereco')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cargo_id', 'setor_id']);
            $table->dropColumn(['cargo_id', 'setor_id', 'telefone', 'endereco']);
        });
    }
};
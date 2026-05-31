<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ALTERA A TABELA EXISTENTE
        Schema::table('cargos', function (Blueprint $table) {
            if (!Schema::hasColumn('cargos', 'descricao')) {
                $table->text('descricao')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cargos', function (Blueprint $table) {
            // $table->dropColumn('descricao');
        });
    }
};
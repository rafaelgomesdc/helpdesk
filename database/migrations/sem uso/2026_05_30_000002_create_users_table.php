<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ALTERA a tabela existente, NÃO cria do zero
        Schema::table('users', function (Blueprint $table) {

            //Campos que existia ou se deseja adicionar — SÓ ADICIONA SE NÃO EXISTIR 🔽
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            if (!Schema::hasColumn('users', 'contato')) {
                $table->string('contato', 255)->nullable();
            }

            if (!Schema::hasColumn('users', 'perfil_id')) {
                $table->bigInteger('perfil_id')->unsigned()->nullable();
            }

            if (!Schema::hasColumn('users', 'cargo_id')) {
                $table->bigInteger('cargo_id')->unsigned()->nullable();
            }

            if (!Schema::hasColumn('users', 'setor_id')) {
                $table->bigInteger('setor_id')->unsigned()->nullable();
            }

            if (!Schema::hasColumn('users', 'telefone')) {
                $table->string('telefone', 20)->nullable();
            }

            if (!Schema::hasColumn('users', 'endereco')) {
                $table->text('endereco')->nullable();
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['user', 'technician', 'admin'])->default('user');
            }

            // Se precisar adicionar chaves estrangeiras:
            //$table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('set null');
            //$table->foreign('setor_id')->references('id')->on('setores')->onDelete('set null');
            $table->foreignId('setor_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('cargo_id')->nullable()->constrained()->onDelete('set null');
            $table->rememberToken();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //  definimos o que remover se precisar reverter
            $table->dropForeign(['cargo_id', 'setor_id']);
            $table->dropColumn([
                'contato', 'perfil_id', 'cargo_id', 'setor_id',
                'telefone', 'endereco', 'role'
            ]);
        });
    }
};
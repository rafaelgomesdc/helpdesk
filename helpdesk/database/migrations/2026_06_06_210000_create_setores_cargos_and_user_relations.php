<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setores', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('setor_id')->nullable()->constrained('setores')->nullOnDelete();
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable()->after('phone');
            $table->foreignId('setor_id')->nullable()->after('profile');
            $table->foreignId('role_id')->nullable()->after('setor_id')->constrained('roles')->nullOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['sector_id', 'cargo_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('cargo_id')->nullable()->after('setor_id')->constrained('cargos')->nullOnDelete();
        });

        Schema::table('permission_role', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->unique(['role_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['permission_id']);
            $table->dropUnique(['role_id', 'permission_id']);
            $table->dropColumn(['role_id', 'permission_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cargo_id']);
            $table->dropColumn('cargo_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('sector_id')->nullable();
            $table->string('cargo_id')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['address', 'setor_id', 'role_id']);
        });

        Schema::dropIfExists('cargos');
        Schema::dropIfExists('setores');
    }
};

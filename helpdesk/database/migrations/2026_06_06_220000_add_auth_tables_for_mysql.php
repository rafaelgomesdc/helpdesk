<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('permission_role')) {
            Schema::create('permission_role', function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
                $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
                $table->unique(['role_id', 'permission_id']);
                $table->timestamps();
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'security_question')) {
                $table->string('security_question')->nullable()->after('password');
            }
            if (! Schema::hasColumn('users', 'security_answer')) {
                $table->string('security_answer')->nullable()->after('security_question');
            }
        });

        if (Schema::hasTable('cargos') && ! Schema::hasColumn('cargos', 'setor_id')) {
            Schema::table('cargos', function (Blueprint $table) {
                $table->foreignId('setor_id')->nullable()->after('nome')->constrained('setores')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'security_question')) {
                $table->dropColumn('security_question');
            }
            if (Schema::hasColumn('users', 'security_answer')) {
                $table->dropColumn('security_answer');
            }
        });

        if (Schema::hasTable('cargos') && Schema::hasColumn('cargos', 'setor_id')) {
            Schema::table('cargos', function (Blueprint $table) {
                $table->dropForeign(['setor_id']);
                $table->dropColumn('setor_id');
            });
        }

        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};

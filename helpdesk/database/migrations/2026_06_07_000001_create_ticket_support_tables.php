<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('comentarios')) {
            Schema::create('comentarios', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->text('conteudo');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('ticket_attachments')) {
            Schema::create('ticket_attachments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
                $table->string('filename');
                $table->string('path');
                $table->unsignedBigInteger('size')->nullable();
                $table->string('mime_type')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('ticket_histories')) {
            Schema::create('ticket_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('action');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('prioridades')) {
            Schema::create('prioridades', function (Blueprint $table) {
                $table->id();
                $table->string('nome', 50);
                $table->unsignedTinyInteger('nivel')->default(1);
                $table->string('cor', 20)->default('#6c757d');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->text('pergunta');
                $table->text('resposta');
                $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('artigos')) {
            Schema::create('artigos', function (Blueprint $table) {
                $table->id();
                $table->string('titulo');
                $table->longText('conteudo');
                $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
                $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('artigos');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('prioridades');
        Schema::dropIfExists('ticket_histories');
        Schema::dropIfExists('ticket_attachments');
        Schema::dropIfExists('comentarios');
    }
};

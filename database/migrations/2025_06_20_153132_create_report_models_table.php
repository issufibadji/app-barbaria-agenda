<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_models', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // Definir UUID como chave primária
            $table->string('name'); // Nome do relatório
            $table->string('open_mode'); // Modo de abertura: mesma página ou nova
            $table->json('acl')->nullable(); // Permissões do relatório em formato JSON
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Nova coluna para armazenar o ID do usuário criador
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_models');
    }
};

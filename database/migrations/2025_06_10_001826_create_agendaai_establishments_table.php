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
        Schema::create('agendaai_establishments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // UUID único
            $table->string('name');          // Nome do estabelecimento
            $table->string('link');          // Link para acesso (ex: site, agendamento)
            $table->string('image')->nullable(); // Imagem do estabelecimento
            $table->text('descrition')->nullable(); // Descrição opcional
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // created_at / updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendaai_establishments');
    }
};

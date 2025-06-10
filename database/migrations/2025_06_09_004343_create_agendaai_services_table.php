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
        Schema::create('agendaai_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // Definir UUID como chave primária
            $table->string('name'); // Nome do relatório
            $table->integer('duration_min');
            $table->decimal('price', 8, 2);
            $table->string('image')->nullable();
            $table->text('descrition')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendaai_services');
    }
};

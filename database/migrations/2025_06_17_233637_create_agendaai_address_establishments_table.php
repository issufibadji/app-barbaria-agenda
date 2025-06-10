<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendaai_address_establishments', function (Blueprint $table) {
            $table->id();
            $table->string('cep')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('complement')->nullable();
            $table->foreignId('establishment_id')
                  ->constrained('agendaai_establishments')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendaai_address_establishments');
    }
};

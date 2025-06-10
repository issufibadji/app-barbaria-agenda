<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendaai_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')
                  ->constrained('agendaai_services')
                  ->onDelete('cascade');
            $table->foreignId('client_id')
                  ->constrained('agendaai_clients')
                  ->onDelete('cascade');
            $table->dateTime('scheduled_at');
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])
                  ->default('pendente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendaai_appointments');
    }
};

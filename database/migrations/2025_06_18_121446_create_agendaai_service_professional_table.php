<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendaai_service_professional', function (Blueprint $table) {
            // chaves estrangeiras
            $table->foreignId('service_id')
                  ->constrained('agendaai_services')
                  ->onDelete('cascade');

            $table->foreignId('professional_id')
                  ->constrained('agendaai_professionals')
                  ->onDelete('cascade');

            $table->timestamps();

            $table->primary(['service_id','professional_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendaai_service_professional');
    }
};

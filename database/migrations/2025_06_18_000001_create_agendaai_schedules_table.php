<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agendaai_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('schedule');
            $table->foreignId('professional_id')
                  ->constrained('agendaai_professionals')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendaai_schedules');
    }
};

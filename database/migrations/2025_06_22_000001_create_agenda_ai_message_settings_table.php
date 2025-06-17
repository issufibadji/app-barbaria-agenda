<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agenda_ai_message_settings', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('message');
            $table->foreignId('establishment_id')->nullable()
                  ->constrained('agendaai_establishments')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_ai_message_settings');
    }
};

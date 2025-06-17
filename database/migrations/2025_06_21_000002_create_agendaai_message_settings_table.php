<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('agendaai_message_settings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('establishment_id')->constrained('agendaai_establishments')->onDelete('cascade');

    $table->text('confirmation_message')->nullable();
    $table->text('reschedule_message')->nullable();
    $table->text('cancel_message')->nullable();
    $table->text('evaluation_message')->nullable();
    $table->text('promotion_message')->nullable();

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('agendaai_message_settings');
    }
};

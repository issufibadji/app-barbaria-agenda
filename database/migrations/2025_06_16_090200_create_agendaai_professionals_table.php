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
        Schema::create('agendaai_professionals', function (Blueprint $table) {
          $table->id();
          $table->uuid('uuid')->unique();
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
          $table->decimal('commission', 5, 2)->default(0);
          $table->foreignId('establishment_id')->constrained('agendaai_establishments')->onDelete('cascade');
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendaai_professionals');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agendaai_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('days');
            $table->boolean('active')->default(true);
            $table->decimal('price', 8, 2);
            $table->text('descrition')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendaai_plans');
    }
};

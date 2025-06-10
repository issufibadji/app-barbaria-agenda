<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agendaai_payments', function (Blueprint $table) {
            $table->id();

            // foreign key to plans
            $table->foreignId('plan_id')
                  ->constrained('agendaai_plans')
                  ->onDelete('cascade');

             // foreign key to mercado_payments
             //$table->foreignId('mercado_payment_id')->constrained('mercado_payments')->onDelete('cascade');
            $table->string('mercado_payment_id', 100);//Temporaria

            // foreign key to establishments
            $table->foreignId('establishment_id')
                  ->constrained('agendaai_establishments')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendaai_payments');
    }
};

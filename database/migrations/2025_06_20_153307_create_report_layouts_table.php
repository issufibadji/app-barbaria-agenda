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
        Schema::create('report_layouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_model_id')->constrained('report_models')->onDelete('cascade'); // Relaciona com o modelo de relatório
            $table->longText('sql_query'); // Consulta SQL gerada
            $table->longText('blade_template')->nullable(); // Template em Blade/HTML para o relatório
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_layouts');
    }
};

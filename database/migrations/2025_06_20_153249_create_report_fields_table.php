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
        Schema::create('report_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_model_id')->constrained('report_models')->onDelete('cascade'); // Relaciona com o modelo de relatório
            $table->string('field'); // Nome do campo no formato tabela::campo
            $table->string('alias')->nullable(); // Alias do campo, opcional
            $table->boolean('is_filter')->default(false); // Se é um campo de filtro
            $table->boolean('visible_filter')->default(true);
            $table->boolean('orderby')->default(false); // Se o campo será usado em uma cláusula ORDER BY
            $table->boolean('groupby')->default(false); // Se o campo será usado em uma cláusula GROUP BY
            $table->string('filter_operator')->nullable(); // Operador de filtro (>, <, =, etc.)
            $table->string('default_value')->nullable(); // Valor padrão para o filtro
            $table->string('logic')->default('and'); // Lógica (OR ou AND)
            $table->string('field_type')->default('text');
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_fields');
    }
};

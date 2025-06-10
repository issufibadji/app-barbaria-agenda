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
        Schema::create('report_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_model_id')->constrained('report_models')->onDelete('cascade'); // Relaciona com o modelo de relatório
            $table->string('table_origin'); // Nome da tabela de origem
            $table->string('column_origin'); // Coluna da tabela de origem (FK)
            $table->string('relationship_type'); // Tipo de relacionamento (Join, LeftJoin, etc.)
            $table->string('table_target'); // Nome da tabela de destino
            $table->string('column_target'); // Coluna da tabela de destino (PK)
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_relationships');
    }
};

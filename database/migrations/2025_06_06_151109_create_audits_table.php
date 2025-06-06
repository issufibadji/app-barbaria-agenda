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
        $connection = config('audit.drivers.database.connection', config('database.default'));
        $table = config('audit.drivers.database.table', 'audits');
        $morphPrefix = config('audit.user.morph_prefix', 'user');

        Schema::connection($connection)->create($table, function (Blueprint $table) use ($morphPrefix) {
            $table->bigIncrements('id');

            // Usuário que realizou a ação (relacionamento polimórfico)
            $table->string("{$morphPrefix}_type")->nullable();
            $table->unsignedBigInteger("{$morphPrefix}_id")->nullable();

            // Evento de auditoria (created, updated, deleted, etc.)
            $table->string('event');

            // Modelo auditado
            $table->morphs('auditable');

            // Valores antigos e novos
            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();

            // Informações contextuais
            $table->text('url')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 1023)->nullable();

            // Tags customizadas
            $table->string('tags')->nullable();

            // Timestamps
            $table->timestamps();

            // Índices
            $table->index(["{$morphPrefix}_id", "{$morphPrefix}_type"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = config('audit.drivers.database.connection', config('database.default'));
        $table = config('audit.drivers.database.table', 'audits');

        Schema::connection($connection)->dropIfExists($table);
    }
};

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
        Schema::create('menu_side_bars', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('icon')->nullable();             // Ex: mdi-account
            $table->string('style')->nullable();            // Ex: text-red-500
            $table->foreignId('parent_id')->nullable();     // Menu Pai
            $table->unsignedInteger('level')->default(0);   // Nível de hierarquia
            $table->string('route')->nullable();            // Rota Vue/Laravel
            $table->string('acl')->nullable();              // Permissão (ex: 'users.view')
            $table->unsignedInteger('order')->default(0);
            $table->boolean('active')->default(true);
            $table->string('group')->nullable();            // 👈 Novo campo: grupo organizacional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_side_bars');
    }
};

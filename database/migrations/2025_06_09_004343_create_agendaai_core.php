<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        // Remove apenas os serviços inativos
        DB::table('permissions')
            ->where('module', '=', 'agendaai')
            ->delete();

        DB::table('menu_side_bars')
            ->where('module', '=', 'agendaai')
            ->delete();
        Schema::enableForeignKeyConstraints();
    }
};

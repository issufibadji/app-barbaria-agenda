<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agendaai_establishments', function (Blueprint $table) {
            $table->string('manual_chat_link')->nullable()->after('link');
        });
    }

    public function down(): void
    {
        Schema::table('agendaai_establishments', function (Blueprint $table) {
            $table->dropColumn('manual_chat_link');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active_2fa')->default(false)->after('password');
			$table->string('google2fa_secret')->nullable();
            $table->timestamp('email_verified_at')->nullable()->change(); // já existe, garantimos que pode ser null

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active_2fa');
			$table->dropColumn('google2fa_secret');
            $table->dropColumn('active_user');
        });

    }
};

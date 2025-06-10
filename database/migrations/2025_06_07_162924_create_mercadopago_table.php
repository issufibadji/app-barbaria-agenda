<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\MenuSideBar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercado_payments', function (Blueprint $table) {

            $table->id();
            $table->string('id_mp')->nullable();
            $table->decimal('valor', 10, 2);
            $table->decimal('valor_pago', 10, 2)->nullable();
            $table->enum('status', ['criado', 'pendente', 'aprovado', 'cancelado', 'falha']);
            $table->string('status_detail')->nullable();
            $table->string('metodo_pagamento');
            $table->string('qr_code')->nullable();
            $table->string('id_user');
            $table->string('module');
            $table->string('id_module');
            $table->dateTime('data_pagamento')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mercado_payments');
    }
};

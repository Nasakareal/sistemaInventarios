<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPagoToRequisicionesTable extends Migration
{
    public function up()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->string('status_pago')->default('Pendiente')->after('pago');
        });
    }

    public function down()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dropColumn('status_pago');
        });
    }

}

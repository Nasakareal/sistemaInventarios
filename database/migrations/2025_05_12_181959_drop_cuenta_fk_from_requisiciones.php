<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCuentaFkFromRequisiciones extends Migration
{
    public function up()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dropForeign(['cuenta_bancaria_id']);
        });
    }

    public function down()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->foreign('cuenta_bancaria_id')
                  ->references('id')
                  ->on('cuentas_bancarias')
                  ->onDelete('cascade');
        });
    }
}

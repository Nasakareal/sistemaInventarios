<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservacionesAndResguardanteToProductosTable extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->after('depreciacion_anual');
            $table->string('resguardante', 150)->nullable()->after('observaciones');
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['observaciones', 'resguardante']);
        });
    }
}

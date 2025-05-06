<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarcaModeloSerieToProductosTable extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('marca', 100)->nullable()->after('proveedor_id');
            $table->string('modelo', 100)->nullable()->after('marca');
            $table->string('serie', 100)->nullable()->after('modelo');
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['marca', 'modelo', 'serie']);
        });
    }
}

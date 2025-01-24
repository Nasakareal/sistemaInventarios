<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('pais');
            $table->string('nombre_empresa');
            $table->string('tipo_empresa');
            $table->string('rfc')->unique();
            $table->string('telefono');
            $table->string('email')->unique;
            $table->integer('cantidad_impuesto');
            $table->string('nombre_impuesto');
            $table->string('moneda');
            $table->string('direccion');
            $table->string('estado');
            $table->string('ciudad');
            $table->string('codigo_postal');
            $table->text('logo');
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
        Schema::dropIfExists('empresas');
    }
}

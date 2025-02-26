<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('numero_inventario_patrimonial', 100)->nullable()->after('partida');
            $table->string('factura_url')->nullable()->after('numero_inventario_patrimonial');
            $table->string('resguardo_url')->nullable()->after('factura_url');
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['numero_inventario_patrimonial', 'factura_url', 'resguardo_url']);
        });
    }
};


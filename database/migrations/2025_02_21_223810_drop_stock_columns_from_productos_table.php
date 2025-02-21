<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropStockColumnsFromProductosTable extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['cantidad_stock', 'stock_minimo']);
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->integer('cantidad_stock')->default(0);
            $table->integer('stock_minimo')->default(0);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCategoriaPrecioNullableInProductosTable extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable()->change();
            $table->decimal('precio_compra', 10, 2)->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable(false)->change();
            $table->decimal('precio_compra', 10, 2)->default(0.00)->nullable(false)->change();
        });
    }
}

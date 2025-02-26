<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepreciacionToProductosTable extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->integer('vida_util')->nullable()->after('resguardo_url');
            $table->decimal('depreciacion_anual', 10, 2)->nullable()->after('vida_util');
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['vida_util', 'depreciacion_anual']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiltrosToProductosTable extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('area', 100)->nullable()->after('estado');
            $table->string('ur', 50)->nullable()->after('area');
            $table->string('partida', 50)->nullable()->after('ur');
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['area', 'ur', 'partida']);
        });
    }
}

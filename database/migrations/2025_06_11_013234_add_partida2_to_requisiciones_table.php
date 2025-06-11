<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartida2ToRequisicionesTable extends Migration
{
     public function up()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->string('partida2')->nullable()->after('partida');
        });
    }

    public function down()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dropColumn('partida2');
        });
    }
}

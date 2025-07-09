<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequisicionIdToAlertsTable extends Migration
{
    public function up()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->unsignedBigInteger('requisicion_id')->nullable()->after('origen');
            $table->foreign('requisicion_id')->references('id')->on('requisiciones')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropForeign(['requisicion_id']);
            $table->dropColumn('requisicion_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dropUnique('requisiciones_numero_requisicion_unique');
        });
    }

    public function down(): void
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->unique('numero_requisicion');
        });
    }
};

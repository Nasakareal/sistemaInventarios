<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBajasTable extends Migration
{
    public function up()
    {
        Schema::create('bajas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bien_id')->constrained('productos')->onDelete('cascade');
            $table->date('fecha_baja');
            $table->enum('motivo', ['OBSOLETO', 'DAÑO IRREPARABLE', 'DONACIÓN', 'TRASPASO', 'OTRO'])->default('OTRO');
            $table->string('responsable', 150);
            $table->text('observaciones')->nullable();
            $table->string('documento_url', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bajas');
    }
}

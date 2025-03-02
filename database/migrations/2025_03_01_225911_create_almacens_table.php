<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('almacens', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['inmueble', 'consumible']);
            $table->date('fecha_compra')->nullable();
            $table->string('nombre_proveedor')->nullable();
            $table->date('fecha_entrada')->nullable();
            $table->string('recibido_por')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->integer('stock')->default(0);
            $table->string('departamento');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('almacens');
    }
};

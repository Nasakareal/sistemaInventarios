<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisiciones', function (Blueprint $table) {
            $table->id(); // Llave primaria
            $table->date('fecha_requisicion'); // Fecha de requisición o de oficio de pago
            $table->string('numero_requisicion')->unique(); // Número de requisición
            $table->string('ur'); // Unidad responsable
            $table->string('departamento'); // Departamento
            $table->string('partida'); // Partida presupuestal
            $table->string('producto_material'); // Producto o material requerido
            $table->text('justificacion'); // Justificación
            $table->string('oficio_pago')->nullable(); // Oficio de pago
            $table->string('numero_factura')->nullable(); // Número de factura
            $table->string('proveedor'); // Proveedor
            $table->decimal('monto', 15, 2); // Monto de la requisición
            $table->string('status_requisicion'); // Estado de la requisición
            $table->string('turnado_a')->nullable(); // A quién se turnó la requisición
            $table->date('fecha_entrega_rf')->nullable(); // Fecha de entrega a recursos financieros
            $table->date('fecha_pago')->nullable(); // Fecha de pago
            $table->string('banco')->nullable(); // Banco
            $table->string('pago')->nullable(); // Pago (detalle)
            $table->text('observaciones')->nullable(); // Observaciones
            $table->string('referencia')->nullable(); // Referencia general
            $table->string('mes')->nullable(); // Mes
            $table->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias')->onDelete('cascade'); // Relación con cuentas bancarias
            $table->timestamps(); // Marcas de tiempo: created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisiciones');
    }
}

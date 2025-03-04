<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Requisiciones extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'requisiciones';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'fecha_requisicion',
        'numero_requisicion',
        'ur',
        'departamento',
        'partida',
        'producto_material',
        'justificacion',
        'oficio_pago',
        'numero_factura',
        'proveedor',
        'monto',
        'status_requisicion',
        'turnado_a',
        'fecha_entrega_rf',
        'fecha_pago',
        'banco',
        'pago',
        'observaciones',
        'referencia',
        'mes',
        'cuenta_bancaria_id',
        'status_pago',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'fecha_requisicion', 
                'numero_requisicion', 
                'ur', 
                'departamento', 
                'partida', 
                'producto_material',
                'justificacion', 
                'oficio_pago', 
                'numero_factura', 
                'proveedor', 
                'monto', 
                'status_requisicion',
                'turnado_a', 
                'fecha_entrega_rf', 
                'fecha_pago', 
                'banco', 
                'pago', 
                'observaciones',
                'referencia', 
                'mes', 
                'cuenta_bancaria_id', 
                'status_pago'
            ])
            ->useLogName('requisiciones')
            ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "La requisicion ha sido {$eventName}";
    }

    protected $casts = [
        'fecha_requisicion' => 'datetime',
        'fecha_entrega_rf' => 'datetime',
        'fecha_pago' => 'datetime',
    ];

    public function cuentaBancaria()
    {
        return $this->belongsTo(CuentaBancaria::class, 'cuenta_bancaria_id');
    }
}

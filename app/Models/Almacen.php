<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Almacen extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'tipo',
        'fecha_compra',
        'nombre_proveedor',
        'fecha_entrada',
        'recibido_por',
        'fecha_salida',
        'stock',
        'departamento',
    ];

    // Define los atributos que se auditarán
    protected static $logAttributes = ['tipo', 'fecha_compra', 'nombre_proveedor', 'fecha_entrada', 'recibido_por', 'fecha_salida', 'stock', 'departamento'];
    protected static $logName = 'almacen';
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "El almacen ha sido {$eventName}";
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}

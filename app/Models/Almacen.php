<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['tipo', 'fecha_compra', 'nombre_proveedor', 'fecha_entrada', 'recibido_por', 'fecha_salida', 'stock', 'departamento'])
            ->useLogName('almacen')
            ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "El almacen ha sido {$eventName}";
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

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

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}

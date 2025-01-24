<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    use HasFactory;

    protected $table = 'cuentas_bancarias'; // Nombre exacto de la tabla en la base de datos

    protected $fillable = [
        'nombre',
        'numero',
    ];

    public function requisiciones()
    {
        return $this->hasMany(Requisiciones::class, 'cuenta_bancaria_id');
    }
}

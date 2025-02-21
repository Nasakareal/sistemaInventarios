<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    use HasFactory;

    protected $table = 'cuentas_bancarias';

    protected $fillable = [
        'nombre',
        'numero',
    ];

    public function requisiciones()
    {
        return $this->hasMany(\App\Models\Requisiciones::class, 'cuenta_bancaria_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CuentaBancaria extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'cuentas_bancarias';

    protected $fillable = [
        'nombre',
        'numero',
    ];

     // Define los atributos que se auditarán
    protected static $logAttributes = ['nombre', 'numero'];
    protected static $logName = 'CuentaBancaria';
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "La Cuenta Bancaria ha sido {$eventName}";
    }

    public function requisiciones()
    {
        return $this->hasMany(\App\Models\Requisiciones::class, 'cuenta_bancaria_id');
    }
}

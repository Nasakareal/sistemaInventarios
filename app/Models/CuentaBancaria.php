<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CuentaBancaria extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'cuentas_bancarias';

    protected $fillable = [
        'nombre',
        'numero',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nombre', 'numero'])
            ->setLogName('CuentaBancaria')
            ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "La Cuenta Bancaria ha sido {$eventName}";
    }

    public function requisiciones()
    {
        return $this->hasMany(\App\Models\Requisiciones::class, 'cuenta_bancaria_id');
    }
}

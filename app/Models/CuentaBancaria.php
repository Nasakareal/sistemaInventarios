<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Requisiciones;

class CuentaBancaria extends Model
{
    use HasFactory, LogsActivity;

    protected $connection = 'contable';

    protected $table = 'cuenta_bancarias';

    protected $fillable = [
        'fondo_id',
        'nombre',
        'numero',
        'saldo',
    ];

    public $timestamps = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nombre', 'numero', 'saldo'])
            ->useLogName('CuentaBancaria')
            ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "La Cuenta Bancaria ha sido {$eventName}";
    }

    public function fondo()
    {
        return $this->belongsTo(Fondo::class);
    }

    public function requisiciones()
    {
        return $this->hasMany(Requisiciones::class, 'cuenta_bancaria_id');
    }
}

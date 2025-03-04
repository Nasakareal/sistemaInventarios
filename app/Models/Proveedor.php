<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Proveedor extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'proveedores';

    protected $fillable = ['nombre', 'contacto', 'telefono', 'email', 'direccion', 'numero_padron'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nombre', 'contacto', 'telefono', 'email', 'direccion', 'numero_padron'])
            ->setLogName('proveedor')
            ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "El proveedor ha sido {$eventName}";
    }
}

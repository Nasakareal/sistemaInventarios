<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Proveedor extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'proveedores';

    protected $fillable = ['nombre', 'contacto', 'telefono', 'email', 'direccion', 'numero_padron'];

    // Define los atributos que se auditarán
    protected static $logAttributes = ['nombre', 'contacto', 'telefono', 'email', 'direccion', 'numero_padron'];
    protected static $logName = 'proveedor';
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "El proveedor ha sido {$eventName}";
    }
}

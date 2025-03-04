<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Categoria extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['nombre', 'descripcion'];

     // Define los atributos que se auditarán
    protected static $logAttributes = ['nombre', 'descripcion'];
    protected static $logName = 'categoria';
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "La categoría ha sido {$eventName}";
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Carbon\Carbon;

class Servicio extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'frecuencia_semanas',
        'ultima_realizacion',
        'proxima_realizacion',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'nombre', 
                'descripcion', 
                'frecuencia_semanas', 
                'ultima_realizacion', 
                'proxima_realizacion'
            ])
            ->useLogName('servicios')
            ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "El servicio ha sido {$eventName}";
    }

    protected static function booted()
    {
        static::saving(function ($servicio) {
            if (!empty($servicio->ultima_realizacion) && !empty($servicio->frecuencia_semanas)) {
                $servicio->proxima_realizacion = Carbon::parse($servicio->ultima_realizacion)
                    ->addWeeks($servicio->frecuencia_semanas)
                    ->format('Y-m-d');
            }
        });
    }

    public function scopeProximosAVencer($query, $dias = 7)
    {
        return $query->whereBetween('proxima_realizacion', [now(), now()->addDays($dias)]);
    }

    public function scopeAtrasados($query)
    {
        return $query->whereDate('proxima_realizacion', '<', now());
    }

    public function getUltimaRealizacionFormattedAttribute()
    {
        return Carbon::parse($this->ultima_realizacion)->format('d/m/Y');
    }

    public function getProximaRealizacionFormattedAttribute()
    {
        return Carbon::parse($this->proxima_realizacion)->format('d/m/Y');
    }
}

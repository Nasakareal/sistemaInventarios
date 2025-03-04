<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Baja extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'bajas';

    protected $fillable = [
        'bien_id',
        'fecha_baja',
        'motivo',
        'responsable',
        'observaciones',
        'documento_url',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['bien_id', 'fecha_baja', 'motivo', 'responsable', 'observaciones', 'documento_url'])
            ->setLogName('baja')
            ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "La baja ha sido {$eventName}";
    }

    public function bien()
    {
        return $this->belongsTo(Producto::class, 'bien_id');
    }

    protected static function booted()
    {
        static::deleting(function ($baja) {
            if ($baja->documento_url) {
                Storage::delete('public/' . $baja->documento_url);
            }
        });
    }
}

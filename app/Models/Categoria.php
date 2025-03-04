<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Categoria extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['nombre', 'descripcion'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nombre', 'descripcion'])
            ->useLogName('categoria')
            ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "La categoría ha sido {$eventName}";
    }
}

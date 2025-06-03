<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'mensaje',
        'origen',
        'leido',
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    public function requisicion()
    {
        return $this->belongsTo(Requisicion::class);
    }
}

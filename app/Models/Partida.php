<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'partidas';
    protected $connection = 'contable';
    public $timestamps = false; // Si no manejas created_at/updated_at

    protected $fillable = ['capitulo_id', 'nombre', 'descripcion'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{
    protected $table = 'capitulos';
    protected $connection = 'contable';
    public $timestamps = false;

    protected $fillable = ['nombre'];
}

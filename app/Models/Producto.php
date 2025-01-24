<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    /**
     * Atributos que se pueden asignar de forma masiva.
     */
    protected $fillable = [
        'nombre',
        'categoria_id',
        'stock',
        'precio',
    ];

    /**
     * Relación con la categoría.
     * Cada producto pertenece a una categoría.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}

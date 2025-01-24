<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'codigo',           // Este campo será generado automáticamente.
        'nombre',
        'descripcion',
        'categoria_id',
        'proveedor_id',
        'departamento_id',
        'cantidad_stock',
        'stock_minimo',
        'precio_compra',
        'ubicacion',
        'imagen_url',
        'estado',
        'qr_url',           // Almacenará la URL del archivo PNG del QR.
    ];

    // Evento para generar automáticamente el código y el QR después de crear un producto
    protected static function booted()
    {
        static::created(function ($producto) {
            try {
                // Generar un código único basado en el ID del producto
                $codigo = 'PROD-' . str_pad($producto->id, 6, '0', STR_PAD_LEFT);

                // Generar el QR usando la librería Endroid QR Code
                $qrCode = Builder::create()
                    ->data("Producto: {$producto->nombre}, Código: {$codigo}")
                    ->encoding(new Encoding('UTF-8'))
                    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                    ->size(200)
                    ->margin(10)
                    ->build();

                // Ruta donde se guardará el QR
                $qrPath = "qrcodes/{$codigo}.png";

                // Guardar el QR como archivo PNG en el almacenamiento público
                Storage::disk('public')->put($qrPath, $qrCode->getString());

                // Actualizar el producto con el código y la URL del QR
                $producto->update([
                    'codigo' => $codigo,
                    'qr_url' => "storage/{$qrPath}",
                ]);
            } catch (\Exception $e) {
                // Registrar el error en los logs para depuración
                \Log::error('Error al generar el QR para el producto: ' . $e->getMessage());
            }
        });
    }

    // Relación con Categorías
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con Proveedores
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación con Departamentos
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}

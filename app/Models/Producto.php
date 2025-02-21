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
        'codigo',
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
        'qr_url',
        'area',
        'ur',
        'partida',
    ];

    protected static function booted()
    {
        static::created(function ($producto) {
            try {
                $codigo = 'PROD-' . str_pad($producto->id, 6, '0', STR_PAD_LEFT);

                $qrCode = Builder::create()
                    ->data("Producto: {$producto->nombre}, Código: {$codigo}")
                    ->encoding(new Encoding('UTF-8'))
                    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                    ->size(200)
                    ->margin(10)
                    ->build();

                $qrPath = "qrcodes/{$codigo}.png";

                Storage::disk('public')->put($qrPath, $qrCode->getString());

                $producto->update([
                    'codigo' => $codigo,
                    'qr_url' => "storage/{$qrPath}",
                ]);
            } catch (\Exception $e) {
                \Log::error('Error al generar el QR para el producto: ' . $e->getMessage());
            }
        });
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}

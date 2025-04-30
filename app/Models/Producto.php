<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Producto extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'productos';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'categoria_id',
        'proveedor_id',
        'departamento_id',
        'precio_compra',
        'ubicacion',
        'imagen_url',
        'qr_url',
        'estado',
        'area',
        'ur',
        'partida',
        'numero_inventario_patrimonial',
        'factura_url',
        'resguardo_url',
        'vida_util',
        'depreciacion_anual',
        'numero_inventario_saacg',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'codigo',
                'nombre',
                'descripcion',
                'categoria_id',
                'proveedor_id',
                'departamento_id',
                'precio_compra',
                'ubicacion',
                'imagen_url',
                'qr_url',
                'estado',
                'area',
                'ur',
                'partida',
                'numero_inventario_patrimonial',
                'factura_url',
                'resguardo_url',
                'vida_util',
                'depreciacion_anual',
                'numero_inventario_saacg',
            ])
            ->useLogName('producto')
            ->logOnlyDirty();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "El inventario ha sido {$eventName}";
    }

    protected static function booted()
    {
        static::created(function ($producto) {
            try {
                $codigo = 'PROD-' . str_pad($producto->id, 6, '0', STR_PAD_LEFT);

                $qrCode = Builder::create()
                ->data("Producto: {$producto->nombre}, Código: {$codigo}")
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(300)
                ->margin(10)
                ->logoPath(public_path('utm_logo2.png'))
                ->logoResizeToWidth(140)
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

    public function bajas()
    {
        return $this->hasOne(Baja::class, 'bien_id');
    }
}

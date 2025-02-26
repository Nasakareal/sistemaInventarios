<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servicio;
use Carbon\Carbon;

class ServicioSeeder extends Seeder
{
    public function run()
    {
        $servicios = [
            [
                'nombre' => 'Corte de Pasto',
                'descripcion' => 'Servicio de mantenimiento de áreas verdes mediante corte de césped.',
                'frecuencia_semanas' => 3,
                'ultima_realizacion' => Carbon::now()->subWeeks(3),
            ],
            [
                'nombre' => 'Limpieza de Cisternas',
                'descripcion' => 'Desinfección y mantenimiento de cisternas de agua potable.',
                'frecuencia_semanas' => 6,
                'ultima_realizacion' => Carbon::now()->subWeeks(5),
            ],
            [
                'nombre' => 'Mantenimiento de Aulas',
                'descripcion' => 'Revisión y reparación de mobiliario en aulas.',
                'frecuencia_semanas' => 4,
                'ultima_realizacion' => Carbon::now()->subWeeks(4),
            ],
            [
                'nombre' => 'Cambio de Filtros de Agua',
                'descripcion' => 'Sustitución de filtros en bebederos y purificadores.',
                'frecuencia_semanas' => 8,
                'ultima_realizacion' => Carbon::now()->subWeeks(7),
            ],
            [
                'nombre' => 'Revisión de Instalaciones Eléctricas',
                'descripcion' => 'Inspección y mantenimiento de cableado y conexiones eléctricas.',
                'frecuencia_semanas' => 12,
                'ultima_realizacion' => Carbon::now()->subWeeks(10),
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create([
                'nombre' => $servicio['nombre'],
                'descripcion' => $servicio['descripcion'],
                'frecuencia_semanas' => $servicio['frecuencia_semanas'],
                'ultima_realizacion' => $servicio['ultima_realizacion'],
                'proxima_realizacion' => Carbon::parse($servicio['ultima_realizacion'])->addWeeks($servicio['frecuencia_semanas']),
            ]);
        }
    }
}

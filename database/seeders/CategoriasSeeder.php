<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Electrónica', 'descripcion' => 'Dispositivos electrónicos.'],
            ['nombre' => 'Mobiliario', 'descripcion' => 'Muebles de oficina.'],
            ['nombre' => 'Papelería', 'descripcion' => 'Útiles escolares.'],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentosSeeder extends Seeder
{
    public function run()
    {
        DB::table('departamentos')->insert([
            ['nombre' => 'Compras', 'descripcion' => 'Departamento de compras.'],
            ['nombre' => 'Inventarios', 'descripcion' => 'Control de inventarios.'],
        ]);
    }
}

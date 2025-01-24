<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    public function run()
    {
        DB::table('proveedores')->insert([
            [
                'nombre' => 'Proveedor 1',
                'contacto' => 'Juan Pérez',
                'telefono' => '1234567890',
                'email' => 'juan@example.com',
                'direccion' => 'Calle Falsa 123'
            ],
            [
                'nombre' => 'Proveedor 2',
                'contacto' => 'María López',
                'telefono' => '0987654321',
                'email' => 'maria@example.com',
                'direccion' => 'Avenida Siempre Viva'
            ],
        ]);
    }
}

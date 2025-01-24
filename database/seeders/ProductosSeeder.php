<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        DB::table('productos')->insert([
            [
                'codigo' => 'ELEC001',
                'nombre' => 'Laptop',
                'descripcion' => 'Laptop HP',
                'categoria_id' => 1,
                'proveedor_id' => 1,
                'departamento_id' => 2,
                'cantidad_stock' => 10,
                'stock_minimo' => 2,
                'precio_compra' => 15000,
                'precio_venta' => 18000,
                'ubicacion' => 'Almacén 1',
                'estado' => 'ACTIVO'
            ],
            [
                'codigo' => 'PAPE001',
                'nombre' => 'Cuaderno',
                'descripcion' => 'Cuaderno profesional',
                'categoria_id' => 3,
                'proveedor_id' => 2,
                'departamento_id' => 2,
                'cantidad_stock' => 50,
                'stock_minimo' => 10,
                'precio_compra' => 25,
                'precio_venta' => 30,
                'ubicacion' => 'Almacén 2',
                'estado' => 'ACTIVO'
            ],
        ]);
    }
}

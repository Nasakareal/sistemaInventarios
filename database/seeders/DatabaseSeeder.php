<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            CategoriasSeeder::class,
            ProveedoresSeeder::class,
            DepartamentosSeeder::class,
            ProductosSeeder::class,
            CuentasBancariasSeeder::class,
            RequisicionesSeeder::class,
        ]);
    }
}

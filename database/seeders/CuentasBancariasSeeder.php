<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuentasBancariasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cuentas_bancarias')->insert([
            [
                'nombre' => 'BBVA 7227',
                'numero' => '7227',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'BBVA 4911',
                'numero' => '4911',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

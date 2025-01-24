<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequisicionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener los IDs de las cuentas bancarias
        $cuenta7227Id = DB::table('cuentas_bancarias')->where('numero', '7227')->value('id');
        $cuenta4911Id = DB::table('cuentas_bancarias')->where('numero', '4911')->value('id');

        // Insertar las requisiciones con los IDs de las cuentas bancarias
        DB::table('requisiciones')->insert([
            [
                'fecha_requisicion' => '2024-01-22',
                'numero_requisicion' => 'SERVICIO BASICO',
                'ur' => 'DELEGACION ADMINISTRATIVA',
                'departamento' => 'DELEGACION ADMINISTRATIVA',
                'partida' => '26103',
                'producto_material' => 'COMBUSTIBLE',
                'justificacion' => 'CAMIONETA NEGRA',
                'oficio_pago' => '001',
                'numero_factura' => 'AAA55C6CE76E',
                'proveedor' => 'ALZAHI S.A DE C.V',
                'monto' => 1153.51,
                'status_requisicion' => 'SERVICIO REALIZADO',
                'turnado_a' => 'HEIDI',
                'fecha_entrega_rf' => '2024-02-08',
                'fecha_pago' => '2024-02-08',
                'banco' => 'BBVA 7227',
                'pago' => 1153.51,
                'observaciones' => null,
                'referencia' => '2BBVA 7227',
                'cuenta_bancaria_id' => $cuenta7227Id,
            ],
            [
                'fecha_requisicion' => '2024-01-22',
                'numero_requisicion' => 'UTM-074',
                'ur' => 'DELEGACION ADMINISTRATIVA',
                'departamento' => 'SUBDIRECCION DE GASTRONOMIA',
                'partida' => '32903',
                'producto_material' => 'RENTA DE PURIFICADOR DE AGUA',
                'justificacion' => 'MES DE ENERO PARA LABORATORIO DE GASTRONOMIA',
                'oficio_pago' => '002',
                'numero_factura' => 'AA231548',
                'proveedor' => 'PRODUCTOS Y SERVICIOS DEL BAJIO',
                'monto' => 1189.00,
                'status_requisicion' => 'SERVICIO REALIZADO',
                'turnado_a' => 'HEIDI',
                'fecha_entrega_rf' => '2024-02-08',
                'fecha_pago' => '2024-02-08',
                'banco' => 'BBVA 7227',
                'pago' => 1189.00,
                'observaciones' => null,
                'referencia' => '2BBVA 7227',
                'cuenta_bancaria_id' => $cuenta7227Id,
            ],
            [
                'fecha_requisicion' => '2024-01-22',
                'numero_requisicion' => 'UTM/STIC/030/2024',
                'ur' => 'DELEGACION ADMINISTRATIVA',
                'departamento' => 'DEPARTAMENTO DE SERVICIOS DE TECNOLOGIAS DE LA INFORMACION Y COMUNICACION',
                'partida' => '31701',
                'producto_material' => 'SERVICIO DE INTERNET',
                'justificacion' => 'MES DE ENERO',
                'oficio_pago' => '003',
                'numero_factura' => '70DA4FB3',
                'proveedor' => 'METRO CARRIER',
                'monto' => 18270.00,
                'status_requisicion' => 'SERVICIO REALIZADO',
                'turnado_a' => 'HEIDI',
                'fecha_entrega_rf' => '2024-02-08',
                'fecha_pago' => '2024-02-09',
                'banco' => 'BBVA 7227',
                'pago' => 18270.00,
                'observaciones' => null,
                'referencia' => '2BBVA 7227',
                'cuenta_bancaria_id' => $cuenta7227Id,
            ],

            [
                'fecha_requisicion' => '2024-02-01',
                'numero_requisicion' => 'UTM-101',
                'ur' => 'DIRECCIÓN GENERAL',
                'departamento' => 'DEPARTAMENTO DE RECURSOS HUMANOS',
                'partida' => '51101',
                'producto_material' => 'PAGO DE NÓMINA',
                'justificacion' => 'PAGO DE NÓMINA QUINCENAL',
                'oficio_pago' => '004',
                'numero_factura' => 'FAC2024001',
                'proveedor' => 'NÓMINA UTM',
                'monto' => 250000.00,
                'status_requisicion' => 'PAGO REALIZADO',
                'turnado_a' => 'CONTABILIDAD',
                'fecha_entrega_rf' => '2024-02-03',
                'fecha_pago' => '2024-02-04',
                'banco' => 'BBVA 4911',
                'pago' => 250000.00,
                'observaciones' => null,
                'referencia' => '3BBVA 4911',
                'cuenta_bancaria_id' => $cuenta4911Id,
            ],
            [
                'fecha_requisicion' => '2024-02-05',
                'numero_requisicion' => 'UTM-202',
                'ur' => 'DEPARTAMENTO DE TECNOLOGÍA',
                'departamento' => 'SOPORTE TÉCNICO',
                'partida' => '32999',
                'producto_material' => 'ADQUISICIÓN DE SOFTWARE',
                'justificacion' => 'LICENCIA DE OFFICE 365 PARA ADMINISTRACIÓN',
                'oficio_pago' => '005',
                'numero_factura' => 'SOFT202401',
                'proveedor' => 'MICROSOFT MÉXICO',
                'monto' => 15850.00,
                'status_requisicion' => 'PAGO EN PROCESO',
                'turnado_a' => 'HEIDI',
                'fecha_entrega_rf' => '2024-02-07',
                'fecha_pago' => '2024-02-09',
                'banco' => 'BBVA 4911',
                'pago' => 15850.00,
                'observaciones' => 'PAGO DIFERIDO',
                'referencia' => '3BBVA 4911',
                'cuenta_bancaria_id' => $cuenta4911Id,
            ],
            [
                'fecha_requisicion' => '2024-02-10',
                'numero_requisicion' => 'UTM-303',
                'ur' => 'SUBDIRECCIÓN DE INFRAESTRUCTURA',
                'departamento' => 'MANTENIMIENTO',
                'partida' => '32901',
                'producto_material' => 'REPARACIÓN DE EQUIPO',
                'justificacion' => 'REPARACIÓN DE CLIMATIZADORES DE AULAS',
                'oficio_pago' => '006',
                'numero_factura' => 'REP2024002',
                'proveedor' => 'EQUIPOS DEL NORTE S.A.',
                'monto' => 35000.00,
                'status_requisicion' => 'SERVICIO PROGRAMADO',
                'turnado_a' => 'INGENIERÍA',
                'fecha_entrega_rf' => '2024-02-15',
                'fecha_pago' => '2024-02-16',
                'banco' => 'BBVA 4911',
                'pago' => 35000.00,
                'observaciones' => 'PAGO EN DOS EXHIBICIONES',
                'referencia' => '3BBVA 4911',
                'cuenta_bancaria_id' => $cuenta4911Id,
            ],
        ]);
    }
}

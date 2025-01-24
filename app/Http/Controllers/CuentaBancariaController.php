<?php

namespace App\Http\Controllers;

use App\Models\CuentaBancaria;

class CuentaBancariaController extends Controller
{
    public function index()
    {
        $cuentas = CuentaBancaria::withCount('requisiciones')->get();

        return view('requisiciones.index', compact('cuentas'));
    }
}

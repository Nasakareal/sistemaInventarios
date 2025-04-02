<?php

namespace App\Http\Controllers;

use App\Models\CuentaBancaria;
use Illuminate\Http\Request;

class CuentaBancariaController extends Controller
{
   public function index()
    {
        $cuentas = CuentaBancaria::all();
        return view('admin.settings.cuentas.index', compact('cuentas'));
    }

    public function create()
    {
        return view('admin.settings.cuentas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero' => 'nullable|string|max:255',
        ]);

        CuentaBancaria::create($request->all());

        return redirect()->route('cuentas.index')->with('success', 'Cuenta bancaria creada exitosamente.');
    }

    public function show(CuentaBancaria $cuenta)
    {
        return view('admin.settings.cuentas.show', compact('cuenta'));
    }

    public function edit(CuentaBancaria $cuenta)
    {
        return view('admin.settings.cuentas.edit', compact('cuenta'));
    }

    public function update(Request $request, CuentaBancaria $cuenta)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero' => 'nullable|string|max:255',
        ]);

        $cuenta->update($request->all());

        return redirect()->route('cuentas.index')->with('success', 'Cuenta bancaria actualizada exitosamente.');
    }

    public function destroy(CuentaBancaria $cuenta)
    {
        $cuenta->delete();

        return redirect()->route('cuentas.index')->with('success', 'Cuenta bancaria eliminada exitosamente.');
    }
}

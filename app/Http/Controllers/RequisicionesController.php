<?php

namespace App\Http\Controllers;

use App\Models\Requisiciones;
use App\Models\CuentaBancaria;
use Illuminate\Http\Request;

class RequisicionesController extends Controller
{
    public function indexByCuenta($cuentaId)
        {
            $cuentaBancaria = CuentaBancaria::findOrFail($cuentaId);
            $requisiciones = $cuentaBancaria->requisiciones;

            return view('requisiciones.cuentas.index', compact('cuentaBancaria', 'requisiciones'));
        }



    public function index()
    {
        // Obtener todas las requisiciones con la relación cuentaBancaria
        $requisiciones = Requisiciones::with('cuentaBancaria')->get();

        // Si la vista 'requisiciones.index' espera otras variables, agrégalas aquí
        // Por ejemplo, si necesitas listar cuentas, pásalas también
        // $cuentas = CuentaBancaria::all();

        return view('requisiciones.index', compact('requisiciones'));
    }


    public function create(Request $request)
    {
        $cuentaBancariaId = $request->input('cuenta_bancaria_id');
        $cuentaBancaria = \App\Models\CuentaBancaria::findOrFail($cuentaBancariaId);

        // Obtén todos los proveedores
        $proveedores = \App\Models\Proveedor::all();

        return view('requisiciones.cuentas.create', compact('cuentaBancariaId', 'cuentaBancaria', 'proveedores'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'fecha_requisicion' => 'required|date',
            'numero_requisicion' => 'required|string|max:255',
            'ur' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'partida' => 'required|string|max:255',
            'producto_material' => 'required|string|max:255',
            'justificacion' => 'nullable|string',
            'oficio_pago' => 'nullable|string|max:255',
            'numero_factura' => 'nullable|string|max:255',
            'proveedor' => 'nullable|string|max:255',
            'monto' => 'required|numeric',
            'status_requisicion' => 'required|string|max:255',
            'turnado_a' => 'nullable|string|max:255',
            'fecha_entrega_rf' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'banco' => 'nullable|string|max:255',
            'pago' => 'nullable|numeric',
            'observaciones' => 'nullable|string',
            'referencia' => 'nullable|string|max:255',
            'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
        ]);

        Requisiciones::create($request->all());
        return redirect()->route('requisiciones.index')->with('success', 'Requisición creada exitosamente.');
    }

    public function show(Requisiciones $requisicion)
    {
        if (!$requisicion) {
            abort(404, "La requisición no fue encontrada.");
        }

        return view('requisiciones.cuentas.show', compact('requisicion'));
    }



    public function edit(Requisiciones $requisiciones)
    {
        return view('Requisiciones.edit', compact('requisiciones'));
    }

    public function update(Request $request, Requisiciones $requisiciones)
    {
        $request->validate([
            'fecha_requisicion' => 'required|date',
            'numero_requisicion' => 'required|string|max:255',
            'ur' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'partida' => 'required|string|max:255',
            'producto_material' => 'required|string|max:255',
            'justificacion' => 'nullable|string',
            'oficio_pago' => 'nullable|string|max:255',
            'numero_factura' => 'nullable|string|max:255',
            'proveedor' => 'nullable|string|max:255',
            'monto' => 'required|numeric',
            'status_requisicion' => 'required|string|max:255',
            'turnado_a' => 'nullable|string|max:255',
            'fecha_entrega_rf' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'banco' => 'nullable|string|max:255',
            'pago' => 'nullable|numeric',
            'observaciones' => 'nullable|string',
            'referencia' => 'nullable|string|max:255',
            'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
        ]);

        $requisiciones->update($request->all());
        return redirect()->route('requisiciones.index')->with('success', 'Requisición actualizada exitosamente.');
    }

    public function destroy(Requisiciones $requisiciones)
    {
        $requisiciones->delete();
        return redirect()->route('requisiciones.index')->with('success', 'Requisición eliminada exitosamente.');
    }
}

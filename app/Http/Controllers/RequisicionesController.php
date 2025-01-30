<?php

namespace App\Http\Controllers;

use App\Models\Requisiciones;
use App\Models\CuentaBancaria;
use Illuminate\Http\Request;

class RequisicionesController extends Controller
{
    // Método para listar requisiciones asociadas a una cuenta bancaria
    public function indexByCuenta($cuentaId)
    {
        $cuentaBancaria = CuentaBancaria::findOrFail($cuentaId);
        $requisiciones = $cuentaBancaria->requisiciones()->with('cuentaBancaria')->get();

        return view('requisiciones.cuentas.index', compact('cuentaBancaria', 'requisiciones'));
    }

    // Método para listar todas las requisiciones con filtros y cuentas bancarias
    public function index(Request $request)
    {
        $query = Requisiciones::query()->with('cuentaBancaria');

        // Aplicar filtros según los parámetros del request
        if ($request->filled('numero_requisicion')) {
            $query->where('numero_requisicion', 'like', '%' . $request->input('numero_requisicion') . '%');
        }

        if ($request->filled('cuenta_bancaria_id')) {
            $query->where('cuenta_bancaria_id', $request->input('cuenta_bancaria_id'));
        }

        if ($request->filled('monto_min')) {
            $query->where('monto', '>=', $request->input('monto_min'));
        }

        if ($request->filled('monto_max')) {
            $query->where('monto', '<=', $request->input('monto_max'));
        }

        $requisiciones = $query->get();
        $cuentas = CuentaBancaria::all();

        return view('requisiciones.index', compact('requisiciones', 'cuentas'));
    }



    // Mostrar formulario para crear una requisición
    public function create(Request $request)
    {
        $cuentaBancariaId = $request->input('cuenta_bancaria_id');
        $cuentaBancaria = CuentaBancaria::findOrFail($cuentaBancariaId);
        $proveedores = \App\Models\Proveedor::all();

        return view('requisiciones.cuentas.create', compact('cuentaBancariaId', 'cuentaBancaria', 'proveedores'));
    }

    // Guardar una nueva requisición en la base de datos
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

    // Mostrar detalles de una requisición
    public function show(Requisiciones $requisicion)
    {
        if (!$requisicion) {
            abort(404, "La requisición no fue encontrada.");
        }

        return view('requisiciones.cuentas.show', compact('requisicion'));
    }

    // Mostrar formulario para editar una requisición
    public function edit(Requisiciones $requisicion)
    {
        return view('requisiciones.edit', compact('requisicion'));
    }

    // Actualizar una requisición existente
    public function update(Request $request, Requisiciones $requisicion)
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

        $requisicion->update($request->all());

        return redirect()->route('requisiciones.index')->with('success', 'Requisición actualizada exitosamente.');
    }

    // Eliminar una requisición
    public function destroy(Requisiciones $requisicion)
    {
        $requisicion->delete();

        return redirect()->route('requisiciones.index')->with('success', 'Requisición eliminada exitosamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Requisiciones;
use App\Models\CuentaBancaria;
use Illuminate\Http\Request;

class RequisicionesController extends Controller
{
    
    public function index(Request $request)
    {
        $cuentas = CuentaBancaria::all();
        $requisicionesPorCuenta = Requisiciones::select('cuenta_bancaria_id', \DB::raw('count(*) as total'))->groupBy('cuenta_bancaria_id')->pluck('total', 'cuenta_bancaria_id');


        $query = Requisiciones::query()->with('cuentaBancaria');

        if ($request->filled('cuenta_bancaria_id')) {
            $query->where('cuenta_bancaria_id', $request->input('cuenta_bancaria_id'));
        }

        $requisiciones = $query->get();

        $totalRequisiciones = Requisiciones::count();

        return view('requisiciones.index', compact('requisiciones', 'cuentas', 'totalRequisiciones'));
    }


    public function create(Request $request)
    {
        $cuentaBancariaId = $request->input('cuenta_bancaria_id');
        $cuentaBancaria = CuentaBancaria::findOrFail($cuentaBancariaId);
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
            'numero_factura' => 'nullable|string|max:255',
            'proveedor' => 'nullable|string|max:255',
            'monto' => 'required|numeric',
            'status_requisicion' => 'required|string|max:255',
            'turnado_a' => 'nullable|string|max:255',
            'fecha_entrega_rf' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'pago' => 'nullable|numeric',
            'observaciones' => 'nullable|string',
            'referencia' => 'nullable|string|max:255',
            'mes' => 'nullable|string|max:20',
            'status_pago' => 'required|string|in:Pendiente,Pagado',
            'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
        ]);

        $cuentaBancaria = CuentaBancaria::findOrFail($request->cuenta_bancaria_id);

        $ultimoOficio = Requisiciones::whereNotNull('oficio_pago')
            ->orderBy('oficio_pago', 'desc')
            ->value('oficio_pago');

        $nuevoOficio = $ultimoOficio ? str_pad((int)$ultimoOficio + 1, 3, '0', STR_PAD_LEFT) : '001';

        $data = $request->all();
        $data['oficio_pago'] = $nuevoOficio;
        $data['banco'] = $cuentaBancaria->nombre;
        $data['status_pago'] = $request->input('status_pago', 'Pendiente');

        Requisiciones::create($data);

        return redirect()->route('requisiciones.index')->with('success', 'Requisición creada exitosamente con número de oficio ' . $nuevoOficio);
    }

    public function show(Requisiciones $requisicion)
    {
        return view('requisiciones.show', compact('requisicion'));
    }


    public function edit($id)
    {
        $requisicion = Requisiciones::where('id', $id)->firstOrFail();

        $proveedores = \App\Models\Proveedor::all();

        return view('requisiciones.cuentas.edit', compact('requisicion', 'proveedores'));
    }

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
            'mes' => 'nullable|string|max:20',
            'status_pago' => 'required|string|in:Pendiente,Pagado',
            'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
        ]);

        $data = $request->all();
        $data['status_pago'] = $request->input('status_pago');

        $requisicion->update($data);

        return redirect()->route('requisiciones.index')->with('success', 'Requisición actualizada exitosamente.');
    }

    public function destroy(Requisiciones $requisicion)
    {
        $requisicion->delete();

        return redirect()->route('requisiciones.index')->with('success', 'Requisición eliminada exitosamente.');
    }
}

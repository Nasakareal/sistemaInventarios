<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function index(Request $request)
    {
        $query = Almacen::query();

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('departamento')) {
            $query->where('departamento', 'like', "%{$request->departamento}%");
        }
        if ($request->filled('fecha_compra')) {
            $query->whereDate('fecha_compra', $request->fecha_compra);
        }

        $almacenes = $query->get();
        $tipos = ['inmueble', 'consumible'];

        return view('almacen.index', compact('almacenes', 'tipos'));
    }

    public function create()
    {
        $tipos = ['inmueble', 'consumible'];
        $proveedores = Proveedor::all();
        return view('almacen.create', compact('tipos', 'proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:inmueble,consumible',
            'fecha_compra' => 'nullable|date',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'fecha_entrada' => 'nullable|date',
            'recibido_por' => 'nullable|string|max:255',
            'fecha_salida' => 'nullable|date',
            'stock' => 'required|integer|min:0',
            'departamento' => 'required|string|max:255',
        ]);

        try {
            $proveedor = Proveedor::find($request->proveedor_id);
            $nombre_proveedor = $proveedor ? $proveedor->nombre : null;

            Almacen::create([
                'tipo' => $request->tipo,
                'fecha_compra' => $request->fecha_compra,
                'nombre_proveedor' => $nombre_proveedor,
                'fecha_entrada' => $request->fecha_entrada,
                'recibido_por' => $request->recibido_por,
                'fecha_salida' => $request->fecha_salida,
                'stock' => $request->stock,
                'departamento' => $request->departamento,
            ]);

            return redirect()->route('almacen.index')->with('success', 'Artículo agregado al almacén exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('almacen.create')->withErrors(['error' => 'Hubo un problema al registrar el artículo en el almacén.']);
        }
    }

    public function show(Almacen $almacen)
    {
        return view('almacen.show', compact('almacen'));
    }

    public function edit(Almacen $almacen)
    {
        $tipos = ['inmueble', 'consumible'];
        $proveedores = Proveedor::all();
        return view('almacen.edit', compact('almacen', 'tipos', 'proveedores'));
    }

    public function update(Request $request, Almacen $almacen)
    {
        $request->validate([
            'tipo' => 'required|in:inmueble,consumible',
            'fecha_compra' => 'nullable|date',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'fecha_entrada' => 'nullable|date',
            'recibido_por' => 'nullable|string|max:255',
            'fecha_salida' => 'nullable|date',
            'stock' => 'required|integer|min:0',
            'departamento' => 'required|string|max:255',
        ]);

        try {
            $proveedor = Proveedor::find($request->proveedor_id);
            $nombre_proveedor = $proveedor ? $proveedor->nombre : $almacen->nombre_proveedor;

            $almacen->update([
                'tipo' => $request->tipo,
                'fecha_compra' => $request->fecha_compra,
                'nombre_proveedor' => $nombre_proveedor,
                'fecha_entrada' => $request->fecha_entrada,
                'recibido_por' => $request->recibido_por,
                'fecha_salida' => $request->fecha_salida,
                'stock' => $request->stock,
                'departamento' => $request->departamento,
            ]);

            return redirect()->route('almacen.index')->with('success', 'Artículo actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('almacen.edit', $almacen)->withErrors(['error' => 'Hubo un problema al actualizar el artículo.']);
        }
    }

    public function destroy(Almacen $almacen)
    {
        try {
            $almacen->delete();

            return redirect()->route('almacen.index')->with('success', 'Artículo eliminado con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('almacen.index')->withErrors(['error' => 'Hubo un problema al eliminar el artículo.']);
        }
    }
}

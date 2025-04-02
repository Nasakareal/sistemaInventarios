<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'proveedor', 'departamento'])
                         ->whereDoesntHave('bajas');

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }
        if ($request->filled('ur')) {
            $query->where('ur', $request->ur);
        }
        if ($request->filled('partida')) {
            $query->where('partida', $request->partida);
        }
        if ($request->filled('fecha_registro')) {
            $query->whereDate('created_at', $request->fecha_registro);
        }

        $productos = $query->get();
        $areas = Producto::select('area')->distinct()->pluck('area');
        $unidades = Producto::select('ur')->distinct()->pluck('ur');
        $partidas = Producto::select('partida')->distinct()->pluck('partida');

        return view('productos.index', compact('productos', 'areas', 'unidades', 'partidas'));
    }


    public function create()
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $departamentos = Departamento::all();

        return view('productos.create', compact('categorias', 'proveedores', 'departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_compra' => 'required|numeric|min:0',
            'area' => 'nullable|string|max:100',
            'ur' => 'nullable|string|max:50',
            'partida' => 'nullable|string|max:50',
            'numero_inventario_patrimonial' => 'nullable|string|max:100|unique:productos,numero_inventario_patrimonial',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'factura' => 'nullable|file|mimes:pdf|max:2048',
            'resguardo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vida_util' => 'nullable|integer|min:1',
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('imagen')) {
                $data['imagen_url'] = $request->file('imagen')->store('productos', 'public');
            }

            if ($request->hasFile('factura')) {
                $data['factura_url'] = $request->file('factura')->store('facturas', 'public');
            }

            if ($request->hasFile('resguardo')) {
                $data['resguardo_url'] = $request->file('resguardo')->store('resguardos', 'public');
            }

            if (!empty($request->vida_util)) {
                $data['depreciacion_anual'] = $request->precio_compra / $request->vida_util;
            } else {
                $data['depreciacion_anual'] = null;
            }

            Producto::create($data);

            return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('productos.create')->withErrors(['error' => 'Hubo un problema al crear el producto.']);
        }
    }

    public function show(Producto $producto)
    {
        if ($producto->bajas()->exists()) {
            return redirect()->route('productos.index')->withErrors(['error' => 'Este bien ha sido dado de baja y no se puede visualizar.']);
        }

        $producto->load(['categoria', 'proveedor', 'departamento']);
        return view('productos.show', compact('producto'));
    }

    public function downloadQR($id)
    {
        $fileName = sprintf('PROD-%06d.png', $id);
        $filePath = public_path("storage/qrcodes/{$fileName}");

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'El código QR no está disponible para este producto.');
        }

        return response()->download($filePath, "QR_{$fileName}");
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $departamentos = Departamento::all();

        return view('productos.edit', compact('producto', 'categorias', 'proveedores', 'departamentos'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'area' => 'nullable|string|max:100',
            'ur' => 'nullable|string|max:50',
            'partida' => 'nullable|string|max:50',
            'precio_compra' => 'required|numeric|min:0',
            'numero_inventario_patrimonial' => 'nullable|string|max:100|unique:productos,numero_inventario_patrimonial,' . $producto->id,
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'factura' => 'nullable|file|mimes:pdf|max:2048',
            'resguardo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vida_util' => 'nullable|integer|min:1',
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('imagen')) {
                if ($producto->imagen_url) {
                    Storage::delete('public/' . $producto->imagen_url);
                }
                $data['imagen_url'] = $request->file('imagen')->store('productos', 'public');
            }

            if ($request->hasFile('factura')) {
                if ($producto->factura_url) {
                    Storage::delete('public/' . $producto->factura_url);
                }
                $data['factura_url'] = $request->file('factura')->store('facturas', 'public');
            }

            if ($request->hasFile('resguardo')) {
                if ($producto->resguardo_url) {
                    Storage::delete('public/' . $producto->resguardo_url);
                }
                $data['resguardo_url'] = $request->file('resguardo')->store('resguardos', 'public');
            }

            if (!empty($request->vida_util)) {
                $data['depreciacion_anual'] = $request->precio_compra / $request->vida_util;
            } else {
                $data['depreciacion_anual'] = null;
            }

            $producto->update($data);

            return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('productos.edit', $producto)->withErrors(['error' => 'Hubo un problema al actualizar el producto.']);
        }
    }

    public function destroy(Producto $producto)
    {
        try {
            if ($producto->imagen_url) {
                Storage::delete('public/' . $producto->imagen_url);
            }
            if ($producto->factura_url) {
                Storage::delete('public/' . $producto->factura_url);
            }
            if ($producto->resguardo_url) {
                Storage::delete('public/' . $producto->resguardo_url);
            }

            $producto->delete();

            return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('productos.index')->withErrors(['error' => 'Hubo un problema al eliminar el producto.']);
        }
    }
}

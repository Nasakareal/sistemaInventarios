<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Departamento;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'proveedor', 'departamento']);

        // Aplicar filtros si están seleccionados
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }
        if ($request->filled('ur')) {
            $query->where('ur', $request->ur);
        }
        if ($request->filled('partida')) {
            $query->where('partida', $request->partida);
        }

        $productos = $query->get();

        // Obtener valores únicos de área, ur y partida para los filtros
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

        // Obtener valores únicos para los selects
        $areas = Producto::select('area')->distinct()->pluck('area');
        $unidades = Producto::select('ur')->distinct()->pluck('ur');
        $partidas = Producto::select('partida')->distinct()->pluck('partida');

        return view('productos.create', compact('categorias', 'proveedores', 'departamentos', 'areas', 'unidades', 'partidas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_compra' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'area' => 'nullable|string|max:100',
            'ur' => 'nullable|string|max:50',
            'partida' => 'nullable|string|max:50',
        ]);

        try {
            $data = $request->all();

            // Procesar la imagen si existe
            if ($request->hasFile('imagen')) {
                $imagePath = $request->file('imagen')->store('productos', 'public');
                $data['imagen_url'] = "storage/{$imagePath}";
            }

            Producto::create($data);

            return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('productos.create')->withErrors(['error' => 'Hubo un problema al crear el producto. Inténtalo de nuevo.']);
        }
    }

    public function show(Producto $producto)
    {
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

        // Obtener valores únicos para los selects
        $areas = Producto::select('area')->distinct()->pluck('area');
        $unidades = Producto::select('ur')->distinct()->pluck('ur');
        $partidas = Producto::select('partida')->distinct()->pluck('partida');

        return view('productos.edit', compact('producto', 'categorias', 'proveedores', 'departamentos', 'areas', 'unidades', 'partidas'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'area' => 'nullable|string|max:100',
            'ur' => 'nullable|string|max:50',
            'partida' => 'nullable|string|max:50',
        ]);

        try {
            $producto->update($request->all());

            return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('productos.edit', $producto)->withErrors(['error' => 'Hubo un problema al actualizar el producto. Inténtalo de nuevo.']);
        }
    }

    public function destroy(Producto $producto)
    {
        try {
            $producto->delete();

            return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('productos.index')->withErrors(['error' => 'Hubo un problema al eliminar el producto. Inténtalo de nuevo.']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Departamento;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria', 'proveedor', 'departamento'])->get();

        return view('productos.index', compact('productos'));
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
            'cantidad_stock' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
        ]);

        try {
            $data = $request->all();

            // Procesar la imagen si existe
            if ($request->hasFile('imagen')) {
                $imagePath = $request->file('imagen')->store('productos', 'public');
                $data['imagen_url'] = "storage/{$imagePath}"; // Guardar la ruta de la imagen
            }

            // Crear el producto con los datos procesados
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
            'cantidad_stock' => 'required|integer|min:0',
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

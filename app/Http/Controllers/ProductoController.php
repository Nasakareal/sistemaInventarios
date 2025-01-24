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
        // Cargar relaciones necesarias para mostrar la información completa de los productos
        $productos = Producto::with(['categoria', 'proveedor', 'departamento'])->get();

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        // Obtener las categorías, proveedores y departamentos para los selects
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $departamentos = Departamento::all();

        return view('productos.create', compact('categorias', 'proveedores', 'departamentos'));
    }

    public function store(Request $request)
    {
        // Validación de los campos necesarios
        $request->validate([
            'nombre' => 'required|max:150',
            'categoria_id' => 'required|exists:categorias,id',
            'cantidad_stock' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
        ]);

        try {
            // Crear el producto, delegando la lógica del QR al modelo
            $producto = Producto::create($request->all());

            return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente con su código QR.');
        } catch (\Exception $e) {
            // Manejo de errores si algo falla
            return redirect()->route('productos.create')->withErrors(['error' => 'Hubo un problema al crear el producto. Inténtalo de nuevo.']);
        }
    }

    public function show(Producto $producto)
    {
        // Cargar relaciones necesarias
        $producto->load(['categoria', 'proveedor', 'departamento']);

        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        // Obtener las categorías, proveedores y departamentos para los selects
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $departamentos = Departamento::all();

        return view('productos.edit', compact('producto', 'categorias', 'proveedores', 'departamentos'));
    }

    public function update(Request $request, Producto $producto)
    {
        // Validación de los campos necesarios
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'cantidad_stock' => 'required|integer|min:0',
        ]);

        try {
            // Actualizar el producto
            $producto->update($request->all());

            return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
        } catch (\Exception $e) {
            // Manejo de errores si algo falla
            return redirect()->route('productos.edit', $producto)->withErrors(['error' => 'Hubo un problema al actualizar el producto. Inténtalo de nuevo.']);
        }
    }

    public function destroy(Producto $producto)
    {
        try {
            // Eliminar el producto
            $producto->delete();

            return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
        } catch (\Exception $e) {
            // Manejo de errores si algo falla
            return redirect()->route('productos.index')->withErrors(['error' => 'Hubo un problema al eliminar el producto. Inténtalo de nuevo.']);
        }
    }
}

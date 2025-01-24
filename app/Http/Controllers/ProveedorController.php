<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    /**
     * Almacena un nuevo proveedor en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:proveedores,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        // Crear el nuevo proveedor
        $proveedor = Proveedor::create([
            'nombre' => $request->nombre,
        ]);

        // Retornar una respuesta JSON exitosa
        return response()->json([
            'success' => true,
            'proveedor' => $proveedor,
        ]);
    }
}

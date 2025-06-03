<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;

class AlertController extends Controller
{
    /**
     * Recibe una petición POST /api/alerts y crea una alerta.
     */
    public function store(Request $request)
    {
        // Validación de los campos
        $data = $request->validate([
            'tipo'    => 'required|string',
            'mensaje' => 'required|string',
            'origen'  => 'nullable|string',
        ]);

        // Crear la alerta
        $alert = Alert::create($data);

        // Devolver JSON con la alerta creada
        return response()->json([
            'success' => true,
            'alert'   => $alert,
        ], 201);
    }
}

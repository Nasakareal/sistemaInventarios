<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requisicion;

class RequisicionSyncController extends Controller
{
    public function bloquear(Request $request)
    {
        $requisicion = Requisicion::where('numero_requisicion', $request->numero_requisicion)->first();

        if (!$requisicion) {
            return response()->json(['status' => 'not found'], 404);
        }

        $requisicion->bloqueada = $request->bloqueada;
        $requisicion->save();

        return response()->json(['status' => 'ok'], 200);
    }
}

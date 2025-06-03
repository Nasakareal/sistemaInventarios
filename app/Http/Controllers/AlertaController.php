<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlertaController extends Controller
{
    // Mostrar todas las alertas
    public function index()
    {
        $alertas = DB::table('alerts')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('alertas.index', compact('alertas'));
    }

    // Marcar una alerta como leída
    public function marcarLeida($id)
    {
        DB::table('alerts')->where('id', $id)->update([
            'leido' => 1,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Alerta marcada como leída.');
    }

    // Ver una alerta en detalle (opcional)
    public function show($id)
    {
        $alerta = DB::table('alerts')->find($id);

        if (!$alerta) {
            return back()->with('error', 'Alerta no encontrada.');
        }

        return view('alertas.show', compact('alerta'));
    }

    public function update(Request $request, $id)
    {
        DB::table('alerts')->where('id', $id)->update([
            'leido' => 1,
            'updated_at' => now(),
        ]);

        return redirect()->route('alerta.index')->with('success', 'Alerta marcada como leída.');
    }

}

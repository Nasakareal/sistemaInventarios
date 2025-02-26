<?php

namespace App\Http\Controllers;

use App\Models\Baja;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BajaController extends Controller
{
    public function index(Request $request)
    {
        $query = Baja::with('bien');

        if ($request->filled('motivo')) {
            $query->where('motivo', $request->motivo);
        }
        if ($request->filled('responsable')) {
            $query->where('responsable', 'like', "%{$request->responsable}%");
        }
        if ($request->filled('fecha_baja')) {
            $query->whereDate('fecha_baja', $request->fecha_baja);
        }

        $bajas = $query->get();
        $motivos = Baja::select('motivo')->distinct()->pluck('motivo');

        return view('bajas.index', compact('bajas', 'motivos'));
    }

    public function create()
    {
        $bienes = Producto::where('estado', 'ACTIVO')->get();
        return view('bajas.create', compact('bienes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bien_id' => 'required|exists:productos,id',
            'fecha_baja' => 'required|date',
            'motivo' => 'required|in:OBSOLETO,DAÑO IRREPARABLE,DONACIÓN,TRASPASO,OTRO',
            'responsable' => 'required|string|max:150',
            'observaciones' => 'nullable|string',
            'documento' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        try {
            $data = $request->all();

            // Guardar documento de baja si se adjunta
            if ($request->hasFile('documento')) {
                $data['documento_url'] = $request->file('documento')->store('bajas', 'public');
            }

            // Crear la baja en la base de datos
            $baja = Baja::create($data);

            // Marcar el bien como INACTIVO
            $bien = Producto::findOrFail($request->bien_id);
            $bien->update(['estado' => 'INACTIVO']);

            return redirect()->route('bajas.index')->with('success', 'Baja registrada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('bajas.create')->withErrors(['error' => 'Hubo un problema al registrar la baja.']);
        }
    }

    public function show(Baja $baja)
    {
        $baja->load('bien');
        return view('bajas.show', compact('baja'));
    }

    public function edit(Baja $baja)
    {
        $bienes = Producto::where('estado', 'ACTIVO')->orWhere('id', $baja->bien_id)->get();
        return view('bajas.edit', compact('baja', 'bienes'));
    }

    public function update(Request $request, Baja $baja)
    {
        $request->validate([
            'bien_id' => 'required|exists:productos,id',
            'fecha_baja' => 'required|date',
            'motivo' => 'required|in:OBSOLETO,DAÑO IRREPARABLE,DONACIÓN,TRASPASO,OTRO',
            'responsable' => 'required|string|max:150',
            'observaciones' => 'nullable|string',
            'documento' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        try {
            $data = $request->all();

            // Actualizar documento si se sube uno nuevo
            if ($request->hasFile('documento')) {
                if ($baja->documento_url) {
                    Storage::delete('public/' . $baja->documento_url);
                }
                $data['documento_url'] = $request->file('documento')->store('bajas', 'public');
            }

            $baja->update($data);

            return redirect()->route('bajas.index')->with('success', 'Baja actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('bajas.edit', $baja)->withErrors(['error' => 'Hubo un problema al actualizar la baja.']);
        }
    }

    public function destroy(Baja $baja)
    {
        try {
            // Restaurar el estado del bien si se elimina la baja
            $bien = Producto::find($baja->bien_id);
            if ($bien) {
                $bien->update(['estado' => 'ACTIVO']);
            }

            // Eliminar documento asociado
            if ($baja->documento_url) {
                Storage::delete('public/' . $baja->documento_url);
            }

            $baja->delete();

            return redirect()->route('bajas.index')->with('success', 'Baja eliminada con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('bajas.index')->withErrors(['error' => 'Hubo un problema al eliminar la baja.']);
        }
    }
}

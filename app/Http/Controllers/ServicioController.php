<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $query = Servicio::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('proxima_realizacion')) {
            $query->whereDate('proxima_realizacion', $request->proxima_realizacion);
        }

        $servicios = $query->orderBy('proxima_realizacion', 'asc')->get();

        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'frecuencia_semanas' => 'required|integer|min:1',
            'ultima_realizacion' => 'required|date',
        ]);

        try {
            $data = $request->all();
            // Calcular próxima realización sumando la frecuencia en semanas
            $data['proxima_realizacion'] = date('Y-m-d', strtotime("+{$data['frecuencia_semanas']} weeks", strtotime($data['ultima_realizacion'])));

            Servicio::create($data);

            return redirect()->route('servicios.index')->with('success', 'Servicio registrado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('servicios.create')->withErrors(['error' => 'Hubo un problema al registrar el servicio.']);
        }
    }

    public function show(Servicio $servicio)
    {
        return view('servicios.show', compact('servicio'));
    }

    public function edit(Servicio $servicio)
    {
        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'frecuencia_semanas' => 'required|integer|min:1',
            'ultima_realizacion' => 'required|date',
        ]);

        try {
            $data = $request->all();
            // Recalcular la próxima fecha de realización
            $data['proxima_realizacion'] = date('Y-m-d', strtotime("+{$data['frecuencia_semanas']} weeks", strtotime($data['ultima_realizacion'])));

            $servicio->update($data);

            return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('servicios.edit', $servicio)->withErrors(['error' => 'Hubo un problema al actualizar el servicio.']);
        }
    }

    public function destroy(Servicio $servicio)
    {
        try {
            $servicio->delete();
            return redirect()->route('servicios.index')->with('success', 'Servicio eliminado con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('servicios.index')->withErrors(['error' => 'Hubo un problema al eliminar el servicio.']);
        }
    }

    public function json()
    {
        $servicios = Servicio::select('id', 'nombre', 'proxima_realizacion')
            ->get()
            ->map(function ($servicio) {
                $dias_restantes = now()->diffInDays($servicio->proxima_realizacion, false);
                return [
                    'id' => $servicio->id,
                    'nombre' => $servicio->nombre,
                    'proxima_realizacion' => $servicio->proxima_realizacion,
                    'dias_restantes' => $dias_restantes
                ];
            });

        return response()->json($servicios);
    }

}

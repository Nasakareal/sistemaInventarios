<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActividadController extends Controller
{
    public function index()
    {
        // Puedes paginar si tienes muchas actividades.
        $activities = Activity::latest()->paginate(15);
        return view('admin.settings.actividad.index', compact('activities'));
    }

    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return view('admin.settings.actividad.show', compact('activity'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function edit($id)
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
        abort(404);
    }

    public function destroy($id)
    {
        abort(404);
    }
}

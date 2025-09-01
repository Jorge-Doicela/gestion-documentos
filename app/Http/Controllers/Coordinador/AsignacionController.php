<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Asignacion;
use App\Models\Plaza;
use App\Models\User;
use App\Models\PlanTrabajo;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function index()
    {
        $asignaciones = Asignacion::with('plaza', 'estudiante', 'supervisor')->paginate(10);
        return view('coordinador.asignaciones.index', compact('asignaciones'));
    }

    public function create()
    {
        $plazas = Plaza::with('empresa')->where('vacantes', '>', 0)->get();
        $estudiantes = User::role('Estudiante')->get();
        $supervisores = User::role('Tutor Académico')->get();
        return view('coordinador.asignaciones.create', compact('plazas', 'estudiantes', 'supervisores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plaza_id' => 'required|exists:plazas,id',
            'estudiante_id' => 'required|exists:users,id',
            'supervisor_id' => 'nullable|exists:users,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'objetivos' => 'nullable|string',
            'actividades' => 'nullable|string',
        ]);

        $asignacion = Asignacion::create([
            'plaza_id' => $request->plaza_id,
            'estudiante_id' => $request->estudiante_id,
            'supervisor_id' => $request->supervisor_id,
        ]);

        // Generar plan de trabajo inicial
        PlanTrabajo::create([
            'asignacion_id' => $asignacion->id,
            'objetivos' => $request->objetivos,
            'actividades' => $request->actividades,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return redirect()->route('coordinador.asignaciones.index')
            ->with('success', 'Estudiante asignado correctamente con plan de trabajo.');
    }

    public function show(Asignacion $asignacion)
    {
        $asignacion->load('plaza', 'estudiante', 'supervisor', 'planTrabajo');
        return view('coordinador.asignaciones.show', compact('asignacion'));
    }

    public function destroy(Asignacion $asignacion)
    {
        $asignacion->delete();
        return redirect()->route('coordinador.asignaciones.index')
            ->with('success', 'Asignación eliminada correctamente.');
    }
}

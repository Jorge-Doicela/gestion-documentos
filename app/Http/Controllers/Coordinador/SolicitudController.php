<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolicitudPlaza;
use App\Models\Asignacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SolicitudController extends Controller
{
    // Listar todas las solicitudes
    public function index()
    {
        $solicitudes = SolicitudPlaza::with('estudiante', 'plaza.empresa')->where('estado', 'pendiente')->get();
        return view('coordinador.solicitudes.index', compact('solicitudes'));
    }

    // Asignar estudiante a plaza
    public function asignar($id)
    {
        $solicitud = SolicitudPlaza::findOrFail($id);

        // Crear asignación
        $asignacion = Asignacion::create([
            'estudiante_id' => $solicitud->estudiante_id,
            'plaza_id' => $solicitud->plaza_id,
            'coordinador_id' => Auth::id(),
            'fecha_asignacion' => now(),
            'estado' => 'asignado'
        ]);

        // Actualizar solicitud
        $solicitud->estado = 'asignado';
        $solicitud->save();

        // Generar plan de trabajo inicial
        $this->generarPlanTrabajo($asignacion);

        return redirect()->route('solicitudes.index')->with('success', 'Estudiante asignado correctamente.');
    }

    // Rechazar solicitud
    public function rechazar($id)
    {
        $solicitud = SolicitudPlaza::findOrFail($id);
        $solicitud->estado = 'rechazada';
        $solicitud->save();

        return redirect()->route('solicitudes.index')->with('success', 'Solicitud rechazada.');
    }

    // Generar plan de trabajo inicial
    private function generarPlanTrabajo(Asignacion $asignacion)
    {
        // Ejemplo simple: crear archivo PDF o registro inicial
        $contenido = "Plan de trabajo inicial para: " . $asignacion->estudiante->name . "\n";
        $contenido .= "Plaza: " . $asignacion->plaza->area_practica . "\n";
        $contenido .= "Empresa: " . $asignacion->plaza->empresa->nombre . "\n";
        $contenido .= "Fecha inicio: " . $asignacion->plaza->fecha_inicio . "\n";
        $contenido .= "Responsable: Coordinador " . $asignacion->coordinador->name . "\n";

        $ruta = 'planes_trabajo/plan_' . $asignacion->id . '.txt';
        Storage::put($ruta, $contenido);

        // Guardar ruta en la asignación
        $asignacion->plan_trabajo = $ruta;
        $asignacion->save();
    }
}

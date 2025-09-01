<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolicitudPlaza;
use App\Models\Asignacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AsignacionController extends Controller
{
    // Listado de solicitudes pendientes
    public function index()
    {
        $solicitudes = SolicitudPlaza::with(['estudiante', 'plaza.empresa'])
            ->where('estado', 'pendiente')
            ->get();

        return view('coordinador.solicitudes.index', compact('solicitudes'));
    }

    // Asignar estudiante a plaza
    public function asignar(Request $request, SolicitudPlaza $solicitud)
    {
        // Crear asignación
        $asignacion = Asignacion::create([
            'estudiante_id' => $solicitud->estudiante_id,
            'plaza_id' => $solicitud->plaza_id,
            'coordinador_id' => Auth::id(),
            'fecha_asignacion' => now(),
        ]);

        // Cambiar estado de solicitud
        $solicitud->estado = 'asignado';
        $solicitud->save();

        return redirect()->route('solicitudes.index')->with('success', 'Estudiante asignado correctamente.');
    }

    // Rechazar solicitud
    public function rechazar(SolicitudPlaza $solicitud)
    {
        $solicitud->estado = 'rechazada';
        $solicitud->save();

        return redirect()->route('solicitudes.index')->with('success', 'Solicitud rechazada.');
    }
}

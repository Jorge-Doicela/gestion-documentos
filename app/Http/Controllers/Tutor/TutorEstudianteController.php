<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Documento;
use Illuminate\Http\Request;
use App\Models\LogActividad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as HttpRequest;

class TutorEstudianteController extends Controller
{
    // Mostrar listado de estudiantes asignados al tutor autenticado
    public function index()
    {
        $tutor = Auth::user();

        // Obtener estudiantes asignados con paginación
        $estudiantes = $tutor->estudiantesAsignados()->paginate(10);

        // Registrar log acceso al listado
        LogActividad::create([
            'user_id' => $tutor->id,
            'accion' => 'Visualización listado estudiantes',
            'descripcion' => "Tutor {$tutor->name} vio su lista de estudiantes asignados.",
            'ip' => HttpRequest::ip(),
            'user_agent' => HttpRequest::userAgent(),
        ]);

        return view('tutor.estudiantes.index', compact('estudiantes'));
    }

    // Mostrar detalle de un estudiante y listado paginado de documentos
    public function show($id)
    {
        $tutor = Auth::user();

        // Verificar que el estudiante está asignado a este tutor
        $estudiante = User::whereHas('tutor', function ($q) use ($tutor) {
            $q->where('id', $tutor->id);
        })->where('id', $id)->firstOrFail();

        // Obtener documentos con paginación
        $documentos = $estudiante->documentos()->paginate(10);

        // Registrar log
        LogActividad::create([
            'user_id' => $tutor->id,
            'accion' => 'Visualización detalle estudiante',
            'descripcion' => "Tutor {$tutor->name} vio detalles del estudiante {$estudiante->name} (ID: {$estudiante->id})",
            'ip' => HttpRequest::ip(),
            'user_agent' => HttpRequest::userAgent(),
        ]);

        return view('tutor.estudiantes.show', compact('estudiante', 'documentos'));
    }

    // Mostrar vista para revisar un documento específico
    public function revisarDocumento($documentoId)
    {
        $tutor = Auth::user();

        $documento = Documento::findOrFail($documentoId);

        // Validar que el documento pertenece a un estudiante asignado al tutor
        if ($documento->user->tutor_id !== $tutor->id) {
            abort(403, 'No autorizado para ver este documento.');
        }

        return view('tutor.estudiantes.revisar-documento', compact('documento'));
    }
}

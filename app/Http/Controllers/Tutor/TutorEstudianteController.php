<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LogActividad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as HttpRequest;

class TutorEstudianteController extends Controller
{
    public function show($id)
    {
        $tutor = Auth::user();

        // Verificar que el estudiante está asignado a este tutor
        $estudiante = User::whereHas('tutor', function ($q) use ($tutor) {
            $q->where('id', $tutor->id);
        })->where('id', $id)->firstOrFail();

        // Cargar documentos del estudiante con paginación
        $documentos = $estudiante->documentos()->paginate(10);

        // Registrar log de auditoría por acceso a detalle
        LogActividad::create([
            'user_id' => $tutor->id,
            'accion' => 'Visualización detalle estudiante',
            'descripcion' => "Tutor {$tutor->name} vio detalles del estudiante {$estudiante->name} (ID: {$estudiante->id})",
            'ip' => HttpRequest::ip(),
            'user_agent' => HttpRequest::userAgent(),
        ]);

        return view('tutor.estudiantes.show', compact('estudiante', 'documentos'));
    }
}

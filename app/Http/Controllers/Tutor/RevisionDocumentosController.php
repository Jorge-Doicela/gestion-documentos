<?php

namespace App\Http\Controllers\Tutor;

use App\Models\Documento;
use App\Models\Comentario;
use App\Models\LogActividad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class RevisionDocumentosController extends Controller
{
    public function index()
    {
        $documentos = Documento::whereHas('usuario', function ($q) {
            $q->where('tutor_id', auth()->id());
        })
            ->whereIn('estado', ['pendiente_tutor', 'rechazado_coordinador'])
            ->get();

        return view('tutor.revision_documentos.index', compact('documentos'));
    }

    public function show(Documento $documento)
    {
        abort_unless($documento->usuario->tutor_id === auth()->id(), 403);

        if (!in_array($documento->estado, ['pendiente_tutor', 'rechazado_coordinador'])) {
            return redirect()->route('tutor.revision.index')
                ->with('warning', 'El documento ya fue revisado anteriormente.');
        }

        return view('tutor.revision_documentos.show', compact('documento'));
    }

    public function verDocumento(Documento $documento)
    {
        abort_unless($documento->usuario->tutor_id === auth()->id(), 403);

        if (!Storage::disk('public')->exists($documento->ruta_archivo)) {
            abort(404, 'Archivo no encontrado.');
        }

        $fileContent = Storage::disk('public')->get($documento->ruta_archivo);

        return Response::make($fileContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documento->nombre_archivo . '"'
        ]);
    }

    public function aprobar(Request $request, Documento $documento)
    {
        abort_unless($documento->usuario->tutor_id === auth()->id(), 403);

        if (!in_array($documento->estado, ['pendiente_tutor', 'rechazado_coordinador'])) {
            return redirect()->route('tutor.revision.index')
                ->with('warning', 'El documento ya fue revisado anteriormente.');
        }

        $documento->estado = 'aprobado_tutor';
        $documento->fecha_revision = now();
        $documento->save();

        LogActividad::create([
            'user_id' => auth()->id(),
            'accion' => 'Aprobación de documento',
            'descripcion' => "Documento ID {$documento->id} aprobado por tutor.",
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('tutor.revision.index')->with('success', 'Documento aprobado correctamente.');
    }

    public function rechazar(Request $request, Documento $documento)
    {
        abort_unless($documento->usuario->tutor_id === auth()->id(), 403);

        if (!in_array($documento->estado, ['pendiente_tutor', 'rechazado_coordinador'])) {
            return redirect()->route('tutor.revision.index')
                ->with('warning', 'El documento ya fue revisado anteriormente.');
        }

        $request->validate([
            'comentarios' => 'nullable|string|max:2000',
        ]);

        if (!empty(trim($request->comentarios))) {
            Comentario::create([
                'documento_id' => $documento->id,
                'user_id' => auth()->id(),
                'seccion' => 'General',
                'mensaje' => $request->comentarios,
                'tipo' => 'observacion',
                'autor_rol' => 'tutor',
            ]);
        }

        $documento->estado = 'rechazado_tutor';
        $documento->fecha_revision = now();
        $documento->save();

        LogActividad::create([
            'user_id' => auth()->id(),
            'accion' => 'Rechazo de documento',
            'descripcion' => "Documento ID {$documento->id} rechazado por tutor con observaciones.",
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('tutor.revision.index')->with('error', 'Documento rechazado correctamente.');
    }

    public function guardarComentarios(Request $request, Documento $documento)
    {
        abort_unless($documento->usuario->tutor_id === auth()->id(), 403);

        $request->validate([
            'comentarios' => 'required|array',
            'comentarios.*.seccion' => 'required|string|max:100',
            'comentarios.*.mensaje' => 'required|string',
        ]);

        foreach ($request->comentarios as $comentario) {
            Comentario::create([
                'documento_id' => $documento->id,
                'user_id' => auth()->id(),
                'seccion' => $comentario['seccion'],
                'mensaje' => $comentario['mensaje'],
                'tipo' => 'observacion',
                'autor_rol' => 'tutor',
            ]);
        }

        return back()->with('success', 'Comentarios guardados correctamente.');
    }
}

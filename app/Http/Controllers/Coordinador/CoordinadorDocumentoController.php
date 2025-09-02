<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;

class CoordinadorDocumentoController extends Controller
{
    /**
     * Mostrar todos los documentos listos para revisión del coordinador.
     * Incluye:
     * - Documentos subidos por tutores
     * - Documentos de estudiantes aprobados por tutor
     */
    public function index()
    {
        $documentos = Documento::with(['usuario', 'tipoDocumento'])
            ->where(function ($query) {
                $query->where('subido_por', 'tutor')
                    ->orWhere('estado', 'aprobado_tutor');
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('coordinador.documentos.index', compact('documentos'));
    }

    /**
     * Mostrar formulario para revisar un documento específico
     */
    public function show(Documento $documento)
    {
        $comentarios = $documento->comentarios()->with('usuario')->get();

        return view('coordinador.documentos.show', compact('documento', 'comentarios'));
    }

    /**
     * Actualizar el estado y comentarios de un documento.
     */
    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'accion' => 'required|in:aprobar,rechazar',
            'observacion' => 'nullable|string|max:1000',
        ]);

        // Verificar estado: si es estudiante, debe estar aprobado por tutor
        if ($documento->subido_por === 'estudiante' && $documento->estado !== 'aprobado_tutor') {
            return redirect()->route('coordinador.documentos.index')
                ->with('error', 'El documento no está listo para revisión del coordinador.');
        }

        // Decodificar comentarios JSON y agregar/modificar observación del coordinador
        $comentarios = $documento->comentarios_json ? json_decode($documento->comentarios_json, true) : [];
        $comentarios['coordinador'] = $request->input('observacion', '');

        // Cambiar el estado según la acción
        $documento->estado = $request->accion === 'aprobar' ? 'aprobado_final' : 'rechazado_coordinador';
        $documento->comentarios_json = json_encode($comentarios);
        $documento->fecha_revision = now();
        $documento->save();

        return redirect()->route('coordinador.documentos.index')
            ->with('success', 'Documento actualizado correctamente.');
    }

    /**
     * Descargar el archivo del documento
     */
    public function download(Documento $documento)
    {
        if (!\Storage::disk('public')->exists($documento->ruta_archivo)) {
            abort(404, 'Archivo no encontrado');
        }

        return \Storage::disk('public')->download($documento->ruta_archivo, $documento->nombre_archivo);
    }

    /**
     * Ver el PDF directamente en el navegador
     */
    public function view(Documento $documento)
    {
        if (!\Storage::disk('public')->exists($documento->ruta_archivo)) {
            abort(404, 'Archivo no encontrado');
        }

        $fileContent = \Storage::disk('public')->get($documento->ruta_archivo);

        return response($fileContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $documento->nombre_archivo . '"');
    }
}

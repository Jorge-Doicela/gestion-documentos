<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;

class CoordinadorDocumentoController extends Controller
{
    public function index()
    {
        // Cargar documentos aprobados por tutor con la relación usuario y tipoDocumento
        $documentos = Documento::with(['usuario', 'tipoDocumento'])
            ->where('estado', 'aprobado_tutor')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('coordinador.documentos.index', compact('documentos'));
    }

    public function update(Request $request, Documento $documento)
    {
        // Validar la entrada del formulario
        $request->validate([
            'observacion' => 'nullable|string|max:1000',
            'accion' => 'required|in:aprobar,rechazar',
        ]);

        // Verificar que el documento esté en estado válido para revisión final
        if ($documento->estado !== 'aprobado_tutor') {
            return redirect()->route('coordinador.documentos.aprobados')
                ->with('error', 'El documento no está en estado válido para revisión final.');
        }

        // Decodificar comentarios JSON y agregar/modificar observación del coordinador
        $comentarios = $documento->comentarios_json ? json_decode($documento->comentarios_json, true) : [];
        $comentarios['coordinador'] = $request->input('observacion', '');

        // Cambiar el estado del documento según la acción
        if ($request->accion === 'aprobar') {
            $documento->estado = 'aprobado_final';
        } else {
            $documento->estado = 'rechazado_coordinador';
        }

        $documento->comentarios_json = json_encode($comentarios);
        $documento->fecha_revision = now();
        $documento->save();

        return redirect()->route('coordinador.documentos.aprobados')
            ->with('success', 'Documento actualizado correctamente.');
    }
}

<?php

// app/Http/Controllers/Coordinador/CoordinadorDocumentoController.php
namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;

class CoordinadorDocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::with(['estudiante', 'tipoDocumento'])
            ->where('estado', 'aprobado_tutor')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('coordinador.documentos.index', compact('documentos'));
    }

    public function update(Request $request, Documento $documento)
    {
        // Validar entrada
        $request->validate([
            'observacion' => 'nullable|string|max:1000',
            'accion' => 'required|in:aprobar,rechazar',
        ]);

        // Solo puede modificar documentos aprobados por tutor
        if ($documento->estado !== 'aprobado_tutor') {
            return redirect()->route('coordinador.documentos.aprobados')
                ->with('error', 'El documento no está en estado válido para revisión final.');
        }

        // Actualizar comentarios JSON agregando o reemplazando la clave "coordinador"
        $comentarios = $documento->comentarios_json ? json_decode($documento->comentarios_json, true) : [];
        $comentarios['coordinador'] = $request->input('observacion', '');

        // Cambiar estado según acción
        if ($request->accion === 'aprobar') {
            $documento->estado = 'aprobado_final';
        } else {
            $documento->estado = 'no_aprobado_coordinador'; // Define este estado en la BD si no existe
        }

        $documento->comentarios_json = json_encode($comentarios);
        $documento->fecha_revision = now();
        $documento->save();

        return redirect()->route('coordinador.documentos.aprobados')
            ->with('success', 'Documento actualizado correctamente.');
    }
}

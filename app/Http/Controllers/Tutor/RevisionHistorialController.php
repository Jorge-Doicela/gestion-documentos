<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\User;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevisionHistorialController extends Controller
{
    public function index(Request $request)
    {
        // Obtener estudiantes asignados al tutor para mostrar en filtro
        $estudiantes = User::where('tutor_id', Auth::id())->orderBy('name')->get();

        // Obtener tipos de documento existentes
        $tiposDocumento = TipoDocumento::orderBy('nombre')->get();

        $query = Documento::whereHas('usuario', function ($query) {
            $query->where('tutor_id', Auth::id());
        })
            ->whereNotNull('fecha_revision')
            ->with(['usuario', 'tipoDocumento'])
            ->latest('fecha_revision');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_inicio')) {
            $query->where('fecha_revision', '>=', $request->fecha_inicio . ' 00:00:00');
        }

        if ($request->filled('fecha_fin')) {
            $query->where('fecha_revision', '<=', $request->fecha_fin . ' 23:59:59');
        }

        if ($request->filled('estudiante_id')) {
            $query->where('user_id', $request->estudiante_id);
        }

        if ($request->filled('tipo_documento_id')) {
            $query->where('tipo_documento_id', $request->tipo_documento_id);
        }

        $documentos = $query->paginate(10)->withQueryString();

        return view('tutor.revision_documentos.historial', compact('documentos', 'estudiantes', 'tiposDocumento'));
    }
}

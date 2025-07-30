<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Documento;

class EstudianteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $documentos = Documento::where('user_id', $user->id)
            ->with('tipoDocumento')
            ->get();

        $certificado = $user->certificado ?? null;

        return view('estudiante.dashboard', compact('documentos', 'certificado'));
    }
}

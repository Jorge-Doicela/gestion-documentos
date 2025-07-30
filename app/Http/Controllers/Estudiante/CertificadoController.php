<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Certificado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CertificadoController extends Controller
{
    public function descargar($uuid)
    {
        // Buscar certificado del usuario autenticado por UUID
        $certificado = Certificado::where('uuid', $uuid)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $path = 'public/' . $certificado->ruta_pdf;

        // Verificar que el archivo exista
        if (!Storage::exists($path)) {
            abort(404, 'Certificado no encontrado.');
        }

        // Descargar archivo PDF
        return Storage::download($path, 'certificado_' . Auth::user()->name . '.pdf');
    }
}

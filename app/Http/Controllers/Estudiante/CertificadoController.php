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
        $user = Auth::user();

        // Buscar certificado del usuario por uuid y user_id
        $certificado = Certificado::where('uuid', $uuid)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Verificar que el archivo exista
        if (!Storage::exists($certificado->ruta_pdf)) {
            abort(404, 'Certificado no encontrado');
        }

        // Descargar el archivo con nombre personalizado
        return Storage::download($certificado->ruta_pdf, "certificado_{$user->name}.pdf");
    }
}

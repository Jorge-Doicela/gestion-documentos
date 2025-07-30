<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Certificado;
use App\Models\Documento;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use PDF;
use QrCode;
use Carbon\Carbon;

class CertificadoController extends Controller
{
    public function generar(User $user)
    {
        // Validar que todos los documentos estén aprobados final
        $documentos = Documento::where('user_id', $user->id)->get();

        if ($documentos->isEmpty() || $documentos->where('estado', '!=', 'aprobado_final')->count()) {
            return back()->with('error', 'No todos los documentos han sido aprobados final.');
        }

        // Datos para el certificado
        $uuid = Str::uuid()->toString();
        $fecha = Carbon::now();
        $firmadoPor = Auth::user()->name;
        $verificacionUrl = route('certificados.verificar', $uuid);

        // Contenido para firmar digitalmente
        $contenido = $user->name . '|' . $fecha->toDateTimeString() . '|' . $verificacionUrl;
        $hash = hash('sha256', $contenido);

        // Generar QR en base64 con el enlace de verificación
        $qr = base64_encode(QrCode::format('png')->size(150)->generate($verificacionUrl));

        // Generar PDF con la vista Blade
        $pdf = PDF::loadView('coordinador.certificados.plantilla', [
            'estudiante' => $user,
            'fecha' => $fecha,
            'firmadoPor' => $firmadoPor,
            'qr' => $qr,
            'hash' => $hash,
            'uuid' => $uuid,
        ]);

        // Guardar PDF en almacenamiento público
        $ruta = 'certificados/' . $uuid . '.pdf';
        Storage::put('public/' . $ruta, $pdf->output());

        // Guardar registro en BD
        Certificado::create([
            'user_id' => $user->id,
            'uuid' => $uuid,
            'ruta_pdf' => $ruta,
            'hash_verificacion' => $hash,
            'firmado_por' => $firmadoPor,
            'fecha_emision' => $fecha,
        ]);

        return back()->with('success', 'Certificado generado exitosamente.');
    }
}

<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Documento;
use App\Models\TipoDocumento;
use App\Models\Configuracion;
use App\Models\Certificado;
use Illuminate\Support\Facades\Response;

class DocumentoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tiposDocumento = TipoDocumento::orderBy('orden')->get();
        $documentosUsuario = Documento::where('user_id', $user->id)->get()->keyBy('tipo_documento_id');

        $listaDocumentos = $tiposDocumento->map(function ($tipo) use ($documentosUsuario) {
            $documento = $documentosUsuario->get($tipo->id);

            return [
                'tipo_documento' => $tipo,
                'estado' => $documento->estado ?? null,
                'comentarios' => $documento ? $documento->comentarios()->with('usuario')->get() : collect(),
                'ruta_archivo' => $documento->ruta_archivo ?? null,
                'nombre_archivo' => $documento->nombre_archivo ?? null,
                'documento_id' => $documento->id ?? null,
                'fecha_revision' => $documento->fecha_revision ?? null,
            ];
        });

        $certificado = Certificado::where('user_id', $user->id)->first();

        return view('estudiante.documentos.index', compact('listaDocumentos', 'certificado'));
    }

    public function create(TipoDocumento $tipoDocumento)
    {
        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;
        $tiposDocumento = TipoDocumento::orderBy('orden')->get();

        return view('estudiante.documentos.create', compact('tipoDocumento', 'tamanoMB', 'tiposDocumento'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;
        $tamanoKB = $tamanoMB * 1024;
        $rutaBase = Configuracion::where('clave', 'ruta_documentos')->value('valor') ?? 'documentos';

        $request->validate([
            'tipo_documento_id' => ['required', 'exists:tipos_documento,id'],
            'archivo' => ['required', 'file', 'mimes:pdf', "max:$tamanoKB"],
        ], [
            'archivo.mimes' => 'El archivo debe ser un PDF.',
            'archivo.max' => "El archivo no puede superar $tamanoMB MB.",
            'tipo_documento_id.required' => 'Debe seleccionar un tipo de documento.',
            'tipo_documento_id.exists' => 'El tipo de documento no es válido.',
        ]);

        $existe = Documento::where('user_id', $user->id)
            ->where('tipo_documento_id', $request->tipo_documento_id)
            ->where('subido_por', 'tutor')
            ->where('estado', '!=', 'rechazado_coordinador')
            ->exists();

        if ($existe) {
            return back()->withErrors(['archivo' => 'Ya has subido un documento de este tipo.'])->withInput();
        }


        $file = $request->file('archivo');
        $nombreArchivo = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $ruta = $rutaBase . '/' . $user->id . '/' . $nombreArchivo;

        Storage::disk('public')->put($ruta, file_get_contents($file));

        Documento::create([
            'user_id' => $user->id,
            'tipo_documento_id' => $request->tipo_documento_id,
            'nombre_archivo' => $file->getClientOriginalName(),
            'ruta_archivo' => $ruta,
            'estado' => 'pendiente_tutor',
            'comentarios_json' => null,
        ]);

        return redirect()->route('estudiante.documentos.index')->with('success', 'Documento subido correctamente.');
    }

    public function edit(Documento $documento)
    {
        $user = auth()->user();

        if ($documento->user_id !== $user->id && !$user->hasRole('coordinador')) {
            abort(403, 'No autorizado.');
        }

        $tiposDocumento = TipoDocumento::orderBy('orden')->get();
        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;

        return view('estudiante.documentos.edit', compact('documento', 'tiposDocumento', 'tamanoMB'));
    }

    public function update(Request $request, Documento $documento)
    {
        $user = auth()->user();

        if ($documento->user_id !== $user->id && !$user->hasRole('coordinador')) {
            abort(403, 'No autorizado.');
        }

        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;
        $tamanoKB = $tamanoMB * 1024;

        $request->validate([
            'archivo' => "required|file|mimes:pdf|max:$tamanoKB",
        ], [
            'archivo.mimes' => 'El archivo debe ser un PDF.',
            'archivo.max' => "El archivo no puede ser mayor a $tamanoMB MB.",
        ]);

        $file = $request->file('archivo');
        $rutaBase = Configuracion::where('clave', 'ruta_documentos')->value('valor') ?? 'documentos';
        $ruta = $rutaBase . '/' . $documento->user_id . '/' . Str::uuid() . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->put($ruta, file_get_contents($file));

        $documento->update([
            'nombre_archivo' => $file->getClientOriginalName(),
            'ruta_archivo' => $ruta,
            'estado' => 'pendiente_tutor',
            'comentarios_json' => null,
        ]);

        return redirect()->route('estudiante.documentos.index')->with('success', 'Documento actualizado y enviado para revisión.');
    }

    public function show(Documento $documento)
    {
        $user = auth()->user();

        if ($documento->user_id !== $user->id && !$user->hasRole('coordinador')) {
            abort(403, 'No autorizado.');
        }

        $comentarios = $documento->comentarios()->with('usuario')->get();

        return view('estudiante.documentos.show', compact('documento', 'comentarios'));
    }

    public function destroy(Documento $documento)
    {
        $user = auth()->user();

        if ($documento->user_id !== $user->id && !$user->hasRole('coordinador')) {
            abort(403, 'No autorizado.');
        }

        if (Storage::disk('public')->exists($documento->ruta_archivo)) {
            Storage::disk('public')->delete($documento->ruta_archivo);
        }

        $documento->delete();

        return redirect()->route('estudiante.documentos.index')->with('success', 'Documento eliminado correctamente.');
    }

    public function view(Documento $documento)
    {
        $user = auth()->user();

        if ($documento->user_id !== $user->id && !$user->hasRole('coordinador')) {
            abort(403, 'No autorizado.');
        }

        if (!Storage::disk('public')->exists($documento->ruta_archivo)) {
            abort(404, 'Archivo no encontrado');
        }

        $fileContent = Storage::disk('public')->get($documento->ruta_archivo);

        return response($fileContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $documento->nombre_archivo . '"');
    }

    public function download(Documento $documento)
    {
        $user = auth()->user();

        if ($documento->user_id !== $user->id && !$user->hasRole('coordinador')) {
            abort(403, 'No autorizado.');
        }

        if (!Storage::disk('public')->exists($documento->ruta_archivo)) {
            abort(404, 'Archivo no encontrado');
        }

        return Storage::disk('public')->download($documento->ruta_archivo, $documento->nombre_archivo);
    }

    public function descargarCertificado($uuid)
    {
        $user = Auth::user();

        $certificado = Certificado::where('user_id', $user->id)->where('uuid', $uuid)->firstOrFail();

        if (!Storage::disk('public')->exists($certificado->ruta_pdf)) {
            abort(404, 'Certificado no encontrado.');
        }

        return Storage::disk('public')->download($certificado->ruta_pdf, "Certificado_{$user->name}.pdf");
    }

    public function storeTutor(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasRole('tutor')) abort(403);

        $tamanoMB = 5;
        $tamanoKB = $tamanoMB * 1024;
        $rutaBase = 'documentos';

        $request->validate([
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'archivo' => "required|file|mimes:pdf|max:$tamanoKB",
        ]);

        $file = $request->file('archivo');
        $nombreArchivo = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $ruta = "$rutaBase/{$user->id}/$nombreArchivo";

        Storage::disk('public')->put($ruta, file_get_contents($file));

        Documento::create([
            'user_id' => $user->id,
            'tipo_documento_id' => $request->tipo_documento_id,
            'nombre_archivo' => $file->getClientOriginalName(),
            'ruta_archivo' => $ruta,
            'estado' => 'aprobado_tutor',
            'subido_por' => 'tutor',
        ]);

        return redirect()->route('tutor.documentos.index')->with('success', 'Documento subido correctamente.');
    }
}

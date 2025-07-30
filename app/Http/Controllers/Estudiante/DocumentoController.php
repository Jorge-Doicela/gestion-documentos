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
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obtener todos los tipos de documento
        $tiposDocumento = TipoDocumento::orderBy('orden')->get();

        // Obtener documentos subidos por el usuario, agrupados por tipo_documento_id
        $documentosUsuario = Documento::where('user_id', $user->id)->get()->keyBy('tipo_documento_id');

        // Preparar lista combinada para la vista
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

        // Obtener certificado activo del usuario
        $certificado = Certificado::where('user_id', $user->id)->first();

        return view('estudiante.documentos.index', compact('listaDocumentos', 'certificado'));
    }

    public function create()
    {
        $tiposDocumento = TipoDocumento::orderBy('orden')->get();
        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;

        return view('estudiante.documentos.create', compact('tiposDocumento', 'tamanoMB'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;
        $tamanoKB = $tamanoMB * 1024; // max en KB

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

        // Validar si ya existe documento válido para ese tipo
        $existe = Documento::where('user_id', $user->id)
            ->where('tipo_documento_id', $request->tipo_documento_id)
            ->where('estado', '!=', 'rechazado')
            ->exists();

        if ($existe) {
            return back()->withErrors(['archivo' => 'Ya has subido un documento de este tipo. Si fue rechazado, por favor edítalo para subir una nueva versión.'])->withInput();
        }

        $file = $request->file('archivo');
        $nombreArchivo = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $ruta = $rutaBase . '/' . $user->id . '/' . $nombreArchivo;

        Storage::put($ruta, file_get_contents($file));

        Documento::create([
            'user_id' => $user->id,
            'tipo_documento_id' => $request->tipo_documento_id,
            'nombre_archivo' => $file->getClientOriginalName(),
            'ruta_archivo' => $ruta,
            'estado' => 'pendiente',
            'comentarios_json' => null,
        ]);

        return redirect()->route('estudiante.documentos.index')->with('success', 'Documento subido correctamente.');
    }

    public function edit(Documento $documento)
    {
        $this->authorize('update', $documento);

        $tiposDocumento = TipoDocumento::orderBy('orden')->get();
        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;

        return view('estudiante.documentos.edit', compact('documento', 'tiposDocumento', 'tamanoMB'));
    }

    public function update(Request $request, Documento $documento)
    {
        $this->authorize('update', $documento);

        if (!in_array($documento->estado, ['rechazado', 'no_aprobado'])) {
            return redirect()->route('estudiante.documentos.index')->with('error', 'No se puede modificar un documento aprobado o pendiente.');
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

        Storage::put($ruta, file_get_contents($file));

        $documento->update([
            'nombre_archivo' => $file->getClientOriginalName(),
            'ruta_archivo' => $ruta,
            'estado' => 'pendiente',
            'comentarios_json' => null,
        ]);

        return redirect()->route('estudiante.documentos.index')->with('success', 'Documento actualizado y enviado para revisión.');
    }

    public function download($id)
    {
        $documento = Documento::where('user_id', Auth::id())->findOrFail($id);

        // Validar que el archivo exista
        if (!Storage::exists($documento->ruta_archivo)) {
            abort(404, 'Archivo no encontrado');
        }

        return Storage::download($documento->ruta_archivo, $documento->nombre_archivo);
    }

    // Nuevo método para descargar el certificado por UUID
    public function descargarCertificado($uuid)
    {
        $user = Auth::user();

        $certificado = Certificado::where('user_id', $user->id)->where('uuid', $uuid)->firstOrFail();

        if (!Storage::exists($certificado->ruta_pdf)) {
            abort(404, 'Certificado no encontrado.');
        }

        return Storage::download($certificado->ruta_pdf, "Certificado_{$user->name}.pdf");
    }
}

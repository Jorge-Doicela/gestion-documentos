<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoDocumento;
use App\Models\Documento;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::where('user_id', auth()->id())
            ->with('tipo')
            ->get();

        return view('estudiante.documentos.index', compact('documentos'));
    }

    public function create()
    {
        $tipos = TipoDocumento::orderBy('orden')->get();
        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;

        return view('estudiante.documentos.create', compact('tipos', 'tamanoMB'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $tipos = TipoDocumento::orderBy('orden')->get();
        $rutaBase = Configuracion::where('clave', 'ruta_documentos')->value('valor') ?? 'documentos';
        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;
        $tamanoBytes = $tamanoMB * 1024 * 1024;

        foreach ($tipos as $tipo) {
            $inputName = 'documento_' . $tipo->id;

            if ($request->hasFile($inputName)) {
                // Validar que el estudiante no haya subido este tipo
                $existe = Documento::where('user_id', $user->id)
                    ->where('tipo_documento_id', $tipo->id)
                    ->exists();

                if ($existe) {
                    continue; // Salta este tipo si ya está subido
                }

                $file = $request->file($inputName);

                $validator = Validator::make(
                    [$inputName => $file],
                    [$inputName => "required|mimes:pdf|max:$tamanoBytes"],
                    [
                        "$inputName.mimes" => 'El archivo debe ser un PDF.',
                        "$inputName.max" => "El archivo no puede superar $tamanoMB MB.",
                    ]
                );

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                $nombreArchivo = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $ruta = $rutaBase . '/' . $user->id . '/' . $nombreArchivo;
                Storage::put($ruta, file_get_contents($file));

                Documento::create([
                    'user_id' => $user->id,
                    'tipo_documento_id' => $tipo->id,
                    'nombre_archivo' => $file->getClientOriginalName(),
                    'ruta_archivo' => $ruta,
                    'estado' => 'pendiente',
                    'comentarios_json' => null,
                ]);
            }
        }

        return redirect()->route('estudiante.documentos.index')->with('success', 'Documentos subidos correctamente.');
    }

    public function edit(Documento $documento)
    {
        $this->authorize('update', $documento);

        $tipos = TipoDocumento::orderBy('orden')->get();

        return view('estudiante.documentos.edit', compact('documento', 'tipos'));
    }

    public function update(Request $request, Documento $documento)
    {
        $this->authorize('update', $documento);

        if (!in_array($documento->estado, ['rechazado', 'no_aprobado'])) {
            return redirect()->route('estudiante.documentos.index')->with('error', 'No se puede modificar un documento aprobado o pendiente.');
        }

        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;
        $tamanoBytes = $tamanoMB * 1024 * 1024;

        $request->validate([
            'archivo' => "required|file|mimes:pdf|max:$tamanoBytes",
        ], [
            'archivo.mimes' => 'El archivo debe ser un PDF.',
            'archivo.max' => "El archivo no puede ser mayor a $tamanoMB MB.",
        ]);

        $file = $request->file('archivo');
        $ruta = $file->store('documentos/' . $documento->user_id, 'public');

        $documento->update([
            'nombre_archivo' => $file->getClientOriginalName(),
            'ruta_archivo' => $ruta,
            'estado' => 'pendiente',
            'comentarios_json' => null,
        ]);

        return redirect()->route('estudiante.documentos.index')->with('success', 'Documento actualizado y enviado para revisión.');
    }
}

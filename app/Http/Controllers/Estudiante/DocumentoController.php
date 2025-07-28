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

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::where('user_id', auth()->id())->with('tipo')->get();
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
        $tipos = TipoDocumento::all();
        $rutaBase = Configuracion::where('clave', 'ruta_documentos')->value('valor') ?? 'documentos';
        $tamanoMB = Configuracion::where('clave', 'tamano_maximo_documento')->value('valor') ?? 5;
        $tamanoBytes = $tamanoMB * 1024 * 1024;

        foreach ($tipos as $tipo) {
            $inputName = 'documento_' . $tipo->id;

            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);

                $validator = Validator::make(
                    [$inputName => $file],
                    [$inputName => "required|mimes:pdf|max:$tamanoBytes"]
                );

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                $nombreArchivo = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $ruta = $rutaBase . '/' . auth()->id() . '/' . $nombreArchivo;
                Storage::put($ruta, file_get_contents($file));

                Documento::create([
                    'user_id' => auth()->id(),
                    'tipo_documento_id' => $tipo->id,
                    'nombre_archivo' => $file->getClientOriginalName(),
                    'ruta_archivo' => $ruta,
                    'estado' => 'Pendiente',
                ]);
            }
        }

        return redirect()->route('estudiante.documentos.index')->with('success', 'Documentos subidos correctamente.');
    }
}

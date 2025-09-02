<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
{
    public function index(Request $request)
    {
        $query = TipoDocumento::orderBy('orden');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'like', "%{$search}%");
        }

        if ($request->filled('obligatorio')) {
            $obligatorio = $request->input('obligatorio');
            if ($obligatorio === '1' || $obligatorio === '0') {
                $query->where('obligatorio', $obligatorio);
            }
        }

        $tipos = $query->paginate(10)->withQueryString();

        $readonly = auth()->user()->hasRole('Tutor Académico|Estudiante');

        return view('admin.tipos_documento.index', compact('tipos', 'readonly'));
    }


    public function create()
    {
        return view('admin.tipos_documento.create');
    }

    public function store(Request $request)
    {
        // Forzar booleano en 'obligatorio'
        $request->merge([
            'obligatorio' => $request->has('obligatorio') ? true : false,
        ]);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'obligatorio' => 'boolean',
            'orden' => 'required|integer|min:1|unique:tipos_documento,orden',
            'archivo_ejemplo' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // max 5MB
        ]);

        $data = $request->only(['nombre', 'descripcion', 'obligatorio', 'orden']);

        if ($request->hasFile('archivo_ejemplo')) {
            // Guardar el archivo y obtener la ruta relativa
            $archivoPath = $request->file('archivo_ejemplo')->store('documentos/ejemplos', 'public');
            $data['archivo_ejemplo'] = $archivoPath;
        }

        TipoDocumento::create($data);

        return redirect()->route('admin.tipos-documento.index')->with('success', 'Tipo creado correctamente.');
    }

    public function edit(TipoDocumento $tipos_documento)
    {
        return view('admin.tipos_documento.edit', ['tipo' => $tipos_documento]);
    }

    public function update(Request $request, TipoDocumento $tipos_documento)
    {
        $request->merge([
            'obligatorio' => $request->has('obligatorio') ? true : false,
        ]);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'obligatorio' => 'boolean',
            'orden' => 'required|integer|min:1|unique:tipos_documento,orden,' . $tipos_documento->id,
            'archivo_ejemplo' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'obligatorio', 'orden']);

        if ($request->hasFile('archivo_ejemplo')) {
            if ($tipos_documento->archivo_ejemplo) {
                \Storage::disk('public')->delete($tipos_documento->archivo_ejemplo);
            }

            $archivoPath = $request->file('archivo_ejemplo')->store('documentos/ejemplos', 'public');
            $data['archivo_ejemplo'] = $archivoPath;
        }

        $tipos_documento->update($data);

        return redirect()->route('admin.tipos-documento.index')->with('success', 'Tipo actualizado.');
    }

    public function destroy(TipoDocumento $tipos_documento)
    {
        // Opcional: eliminar archivo asociado al borrar el registro
        if ($tipos_documento->archivo_ejemplo) {
            \Storage::disk('public')->delete($tipos_documento->archivo_ejemplo);
        }

        $tipos_documento->delete();
        return redirect()->route('admin.tipos-documento.index')->with('success', 'Tipo eliminado.');
    }

    // Nuevo método para descargar el archivo de ejemplo
    public function download(TipoDocumento $tipo)
    {
        if (!$tipo->archivo_ejemplo || !\Storage::disk('public')->exists($tipo->archivo_ejemplo)) {
            return redirect()->route('admin.tipos-documento.index')
                ->with('error', 'Archivo de ejemplo no encontrado.');
        }

        return \Storage::disk('public')->download($tipo->archivo_ejemplo);
    }
    public function view(TipoDocumento $tipo)
    {
        if (!$tipo->archivo_ejemplo || !\Storage::disk('public')->exists($tipo->archivo_ejemplo)) {
            return redirect()->route('admin.tipos-documento.index')
                ->with('error', 'Archivo de ejemplo no encontrado.');
        }

        $path = \Storage::disk('public')->path($tipo->archivo_ejemplo);
        $mime = \Storage::disk('public')->mimeType($tipo->archivo_ejemplo);

        // Responder con el archivo para que el navegador lo muestre inline
        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($tipo->archivo_ejemplo) . '"',
        ]);
    }
}

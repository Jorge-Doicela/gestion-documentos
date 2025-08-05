<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NormativaDocumento;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;


class NormativaDocumentoController extends Controller
{
    public function __construct()
    {
        // Middleware que asegura que solo usuarios con rol 'Administrador General' accedan
        $this->middleware(['auth', 'role:Administrador General|Coordinador de Prácticas']);
    }

    public function index()
    {
        $normativas = NormativaDocumento::with('tipoDocumento')->paginate(10);
        return view('admin.normativas.index', compact('normativas'));
    }

    public function create()
    {
        $tipos = TipoDocumento::all();
        return view('admin.normativas.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'contenido' => 'required|string',
        ]);

        NormativaDocumento::create($request->only('tipo_documento_id', 'contenido'));

        return redirect()->route('admin.normativas.index')->with('success', 'Normativa creada correctamente.');
    }

    public function edit(NormativaDocumento $normativa)
    {
        $tipos = TipoDocumento::all();
        return view('admin.normativas.edit', compact('normativa', 'tipos'));
    }

    public function update(Request $request, NormativaDocumento $normativa)
    {
        $request->validate([
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'contenido' => 'required|string',
        ]);

        $normativa->update($request->only('tipo_documento_id', 'contenido'));

        return redirect()->route('admin.normativas.index')->with('success', 'Normativa actualizada correctamente.');
    }

    public function destroy(NormativaDocumento $normativa)
    {
        $normativa->delete();
        return redirect()->route('admin.normativas.index')->with('success', 'Normativa eliminada correctamente.');
    }
}

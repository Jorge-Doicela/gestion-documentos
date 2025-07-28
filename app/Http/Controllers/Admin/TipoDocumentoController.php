<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
{
    public function index()
    {
        $tipos = TipoDocumento::orderBy('orden')->get();
        return view('admin.tipos_documento.index', compact('tipos'));
    }

    public function create()
    {
        return view('admin.tipos_documento.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'obligatorio' => 'boolean',
            'orden' => 'required|integer|min:1',
        ]);

        TipoDocumento::create($request->all());

        return redirect()->route('admin.tipos-documento.index')->with('success', 'Tipo creado correctamente.');
    }

    public function edit(TipoDocumento $tipos_documento)
    {
        return view('admin.tipos_documento.edit', ['tipo' => $tipos_documento]);
    }

    public function update(Request $request, TipoDocumento $tipos_documento)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'obligatorio' => 'boolean',
            'orden' => 'required|integer|min:1',
        ]);

        $tipos_documento->update($request->all());

        return redirect()->route('admin.tipos-documento.index')->with('success', 'Tipo actualizado.');
    }

    public function destroy(TipoDocumento $tipos_documento)
    {
        $tipos_documento->delete();
        return redirect()->route('admin.tipos-documento.index')->with('success', 'Tipo eliminado.');
    }
}

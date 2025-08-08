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
        $this->middleware(['auth', 'role:Administrador General|Coordinador de Prácticas']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $normativas = NormativaDocumento::with('tipoDocumento')
            ->when($search, function ($query, $search) {
                $query->whereHas('tipoDocumento', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%");
                })
                    ->orWhere('contenido', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.normativas.index', compact('normativas', 'search'));
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

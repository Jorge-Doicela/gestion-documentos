<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Convenio;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvenioController extends Controller
{
    public function index()
    {
        $convenios = Convenio::with('empresa')->get();
        return view('admin.convenios.index', compact('convenios'));
    }

    public function create()
    {
        $empresas = Empresa::all();
        return view('admin.convenios.create', compact('empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'descripcion' => 'nullable|string',
            'ruta_pdf' => 'required|file|mimes:pdf|max:10240', // hasta 10MB
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'firmado_por_instituto' => 'required|string|max:255',
            'firmado_por_empresa' => 'required|string|max:255',
        ]);

        $pdfPath = $request->file('ruta_pdf')->store('convenios', 'public');

        Convenio::create([
            'empresa_id' => $request->empresa_id,
            'descripcion' => $request->descripcion,
            'ruta_pdf' => $pdfPath,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'firmado_por_instituto' => $request->firmado_por_instituto,
            'firmado_por_empresa' => $request->firmado_por_empresa,
        ]);

        return redirect()->route('admin.convenios.index')
            ->with('success', 'Convenio creado correctamente.');
    }

    public function show(Convenio $convenio)
    {
        return view('admin.convenios.show', compact('convenio'));
    }

    public function edit(Convenio $convenio)
    {
        $empresas = Empresa::all();
        return view('admin.convenios.edit', compact('convenio', 'empresas'));
    }

    public function update(Request $request, Convenio $convenio)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'descripcion' => 'nullable|string',
            'ruta_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'firmado_por_instituto' => 'required|string|max:255',
            'firmado_por_empresa' => 'required|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('ruta_pdf')) {
            // Eliminar PDF anterior
            if ($convenio->ruta_pdf) {
                Storage::disk('public')->delete($convenio->ruta_pdf);
            }
            $data['ruta_pdf'] = $request->file('ruta_pdf')->store('convenios', 'public');
        }

        $convenio->update($data);

        return redirect()->route('admin.convenios.index')
            ->with('success', 'Convenio actualizado correctamente.');
    }

    public function destroy(Convenio $convenio)
    {
        if ($convenio->ruta_pdf) {
            Storage::disk('public')->delete($convenio->ruta_pdf);
        }

        $convenio->delete();

        return redirect()->route('admin.convenios.index')
            ->with('success', 'Convenio eliminado correctamente.');
    }
}

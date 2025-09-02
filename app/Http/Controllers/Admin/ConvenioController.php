<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Convenio;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\ConveniosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ConvenioController extends Controller
{
    /**
     * Mostrar listado de convenios con paginación
     */
    public function index()
    {
        // Paginación: 10 convenios por página, con empresa relacionada
        $convenios = Convenio::with('empresa')
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(10);

        return view('admin.convenios.index', compact('convenios'));
    }

    /**
     * Mostrar formulario de creación de convenio
     */
    public function create()
    {
        $empresas = Empresa::all();
        return view('admin.convenios.create', compact('empresas'));
    }

    /**
     * Guardar nuevo convenio
     */
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

    /**
     * Mostrar detalles de un convenio
     */
    public function show(Convenio $convenio)
    {
        return view('admin.convenios.show', compact('convenio'));
    }

    /**
     * Mostrar formulario de edición de convenio
     */
    public function edit(Convenio $convenio)
    {
        $empresas = Empresa::all();
        return view('admin.convenios.edit', compact('convenio', 'empresas'));
    }

    /**
     * Actualizar convenio
     */
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
            // Eliminar PDF anterior si existe
            if ($convenio->ruta_pdf) {
                Storage::disk('public')->delete($convenio->ruta_pdf);
            }
            $data['ruta_pdf'] = $request->file('ruta_pdf')->store('convenios', 'public');
        }

        $convenio->update($data);

        return redirect()->route('admin.convenios.index')
            ->with('success', 'Convenio actualizado correctamente.');
    }

    /**
     * Eliminar convenio
     */
    public function destroy(Convenio $convenio)
    {
        // Eliminar PDF asociado si existe
        if ($convenio->ruta_pdf) {
            Storage::disk('public')->delete($convenio->ruta_pdf);
        }

        $convenio->delete();

        return redirect()->route('admin.convenios.index')
            ->with('success', 'Convenio eliminado correctamente.');
    }

    /**
     * Exportar convenios a Excel
     */
    public function exportExcel()
    {
        return Excel::download(new ConveniosExport, 'convenios.xlsx');
    }

    /**
     * Exportar convenios a PDF
     */
    public function exportPdf()
    {
        // Obtener todos los convenios, sin paginar, para exportación completa
        $convenios = Convenio::with('empresa')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.convenios.pdf', compact('convenios'));
        return $pdf->download('convenios.pdf');
    }
}

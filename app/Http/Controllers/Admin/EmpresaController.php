<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Exports\EmpresasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class EmpresaController extends Controller
{
    /**
     * Mostrar lista de empresas con filtros y paginación.
     */
    public function index(Request $request)
    {
        $empresas = Empresa::query();

        // Filtros dinámicos
        if ($request->filled('nombre')) {
            $empresas->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('ruc')) {
            $empresas->where('ruc', $request->ruc);
        }

        $empresas = $empresas->orderBy('nombre')->paginate(10);

        return view('admin.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('admin.empresas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruc' => 'required|string|max:20|unique:empresas',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contacto' => 'nullable|string|max:255',
        ]);

        Empresa::create($request->all());

        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa creada correctamente.');
    }

    public function show(Empresa $empresa)
    {
        return view('admin.empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('admin.empresas.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruc' => 'required|string|max:20|unique:empresas,ruc,' . $empresa->id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contacto' => 'nullable|string|max:255',
        ]);

        $empresa->update($request->all());

        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa actualizada correctamente.');
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa eliminada correctamente.');
    }

    public function exportExcel()
    {
        return Excel::download(new EmpresasExport, 'empresas.xlsx');
    }

    public function exportPdf()
    {
        $empresas = Empresa::all();
        $pdf = Pdf::loadView('admin.empresas.pdf', compact('empresas'));
        return $pdf->download('empresas.pdf');
    }
}

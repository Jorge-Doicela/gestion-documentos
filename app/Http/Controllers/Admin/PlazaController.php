<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plaza;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\PlazasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PlazaController extends Controller
{
    // ------------------------
    // CRUD existente
    // ------------------------
    public function index(Request $request)
    {
        $plazas = Plaza::with('empresa'); // CORREGIDO

        // Filtros dinámicos
        if ($request->filled('empresa_id')) {
            $plazas->where('empresa_id', $request->empresa_id);
        }

        if ($request->filled('carrera')) {
            $plazas->where('carrera', $request->carrera);
        }

        if ($request->filled('periodo_academico')) {
            $plazas->where('periodo_academico', $request->periodo_academico);
        }

        if ($request->filled('vigentes')) {
            $hoy = date('Y-m-d');
            $plazas->where('fecha_inicio', '<=', $hoy)
                ->where('fecha_fin', '>=', $hoy);
        }

        $plazas = $plazas->orderBy('fecha_inicio', 'asc')->paginate(10);

        // Para select de empresa en el filtro
        $empresas = Empresa::orderBy('nombre')->get();

        return view('admin.plazas.index', compact('plazas', 'empresas'));
    }



    public function create()
    {
        $empresas = Empresa::all();
        return view('admin.plazas.create', compact('empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'area_practica' => 'required|string|max:255',
            'periodo_academico' => 'required|string|max:50',
            'carrera' => 'required|string|max:100',
            'habilidades_requeridas' => 'nullable|string',
            'documentos_previos' => 'nullable|array',
            'vacantes' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        Plaza::create($request->all());

        return redirect()->route('admin.plazas.index')
            ->with('success', 'Plaza creada correctamente.');
    }

    public function show(Plaza $plaza)
    {
        return view('admin.plazas.show', compact('plaza'));
    }

    public function edit(Plaza $plaza)
    {
        $empresas = Empresa::all();
        return view('admin.plazas.edit', compact('plaza', 'empresas'));
    }

    public function update(Request $request, Plaza $plaza)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'area_practica' => 'required|string|max:255',
            'periodo_academico' => 'required|string|max:50',
            'carrera' => 'required|string|max:100',
            'habilidades_requeridas' => 'nullable|string',
            'documentos_previos' => 'nullable|array',
            'vacantes' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $plaza->update($request->all());

        return redirect()->route('admin.plazas.index')
            ->with('success', 'Plaza actualizada correctamente.');
    }

    public function destroy(Plaza $plaza)
    {
        $plaza->delete();
        return redirect()->route('admin.plazas.index')
            ->with('success', 'Plaza eliminada correctamente.');
    }

    // ------------------------
    // NUEVO MÉTODO: plazas disponibles para estudiantes
    // ------------------------
    /**
     * Mostrar plazas disponibles para estudiantes según su carrera.
     */
    public function disponibles(Request $request)
    {
        $usuario = Auth::user();

        // Asumimos que el usuario tiene campo 'carrera'
        $carrera = $usuario->carrera;

        $hoy = date('Y-m-d');

        $plazas = Plaza::where('carrera', $carrera)
            ->where('vacantes', '>', 0)
            ->where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->orderBy('fecha_inicio', 'asc');

        // Filtros opcionales
        if ($request->filled('periodo_academico')) {
            $plazas->where('periodo_academico', $request->periodo_academico);
        }

        if ($request->filled('empresa_id')) {
            $plazas->where('empresa_id', $request->empresa_id);
        }

        $plazas = $plazas->paginate(10); // Paginación

        return view('plazas.disponibles', compact('plazas'));
    }
    // Export Excel
    public function exportExcel(Request $request)
    {
        $filters = $request->only(['empresa_id', 'carrera', 'periodo_academico', 'vigentes']);
        return Excel::download(new PlazasExport($filters), 'plazas.xlsx');
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $query = Plaza::with('empresa');

        // Aplicar filtros
        if ($request->filled('empresa_id')) {
            $query->where('empresa_id', $request->empresa_id);
        }
        if ($request->filled('carrera')) {
            $query->where('carrera', $request->carrera);
        }
        if ($request->filled('periodo_academico')) {
            $query->where('periodo_academico', $request->periodo_academico);
        }
        if ($request->filled('vigentes')) {
            $hoy = date('Y-m-d');
            $query->where('fecha_inicio', '<=', $hoy)
                ->where('fecha_fin', '>=', $hoy);
        }

        $plazas = $query->get();

        $pdf = Pdf::loadView('admin.plazas.pdf', compact('plazas'));
        return $pdf->download('plazas.pdf');
    }
}

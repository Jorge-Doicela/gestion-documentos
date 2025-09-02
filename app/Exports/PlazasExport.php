<?php

namespace App\Exports;

use App\Models\Plaza;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class PlazasExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Plaza::with('empresa');

        // Aplicar filtros si existen
        if (!empty($this->filters['empresa_id'])) {
            $query->where('empresa_id', $this->filters['empresa_id']);
        }
        if (!empty($this->filters['carrera'])) {
            $query->where('carrera', $this->filters['carrera']);
        }
        if (!empty($this->filters['periodo_academico'])) {
            $query->where('periodo_academico', $this->filters['periodo_academico']);
        }
        if (!empty($this->filters['vigentes'])) {
            $hoy = date('Y-m-d');
            $query->where('fecha_inicio', '<=', $hoy)
                ->where('fecha_fin', '>=', $hoy);
        }

        return $query->get()->map(function ($plaza) {
            return [
                'Empresa' => $plaza->empresa->nombre,
                'Área' => $plaza->area_practica,
                'Período' => $plaza->periodo_academico,
                'Carrera' => $plaza->carrera,
                'Vacantes' => $plaza->vacantes,
                'Fechas' => $plaza->fecha_inicio . ' - ' . $plaza->fecha_fin,
            ];
        });
    }

    public function headings(): array
    {
        return ['Empresa', 'Área', 'Período', 'Carrera', 'Vacantes', 'Fechas'];
    }
}

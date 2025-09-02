<?php

namespace App\Exports;

use App\Models\Convenio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConveniosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Convenio::with('empresa')->get()->map(function ($convenio) {
            return [
                'Empresa' => $convenio->empresa->nombre,
                'Fecha Inicio' => $convenio->fecha_inicio->format('d/m/Y'),
                'Fecha Fin' => $convenio->fecha_fin->format('d/m/Y'),
                'Firmado por Instituto' => $convenio->firmado_por_instituto,
                'Firmado por Empresa' => $convenio->firmado_por_empresa,
                'Descripción' => $convenio->descripcion ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return ['Empresa', 'Fecha Inicio', 'Fecha Fin', 'Firmado por Instituto', 'Firmado por Empresa', 'Descripción'];
    }
}

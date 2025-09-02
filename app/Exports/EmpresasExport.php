<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpresasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Empresa::select('nombre', 'ruc', 'telefono', 'email', 'contacto')->get();
    }

    public function headings(): array
    {
        return ['Nombre', 'RUC', 'Teléfono', 'Email', 'Contacto'];
    }
}

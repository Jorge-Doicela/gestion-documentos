<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = User::with(['roles', 'carrera', 'tutor']);

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(fn($q) => $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%"));
        }

        if (!empty($this->filters['role'])) {
            $query->role($this->filters['role']);
        }

        if (!empty($this->filters['carrera_id'])) {
            $query->where('carrera_id', $this->filters['carrera_id']);
        }

        if (!empty($this->filters['tutor_id'])) {
            $query->where('tutor_id', $this->filters['tutor_id']);
        }

        return $query->get()->map(function ($user) {
            return [
                'Nombre'     => $user->name,
                'Email'      => $user->email,
                'Rol'        => $user->roles->pluck('name')->join(', '),
                'Teléfono'   => $user->telefono ?? '-',
                'Carrera'    => $user->carrera->nombre ?? '-',
                'Tutor'      => $user->tutor->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['Nombre', 'Email', 'Rol', 'Teléfono', 'Carrera', 'Tutor'];
    }
}

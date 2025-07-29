@extends('layouts.app')

@section('title', 'Estudiantes Asignados')

@section('content')
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Estudiantes Asignados</h1>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full table-auto text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">Correo</th>
                        <th class="p-3">Documentos</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($estudiantes as $est)
                        <tr class="border-b">
                            <td class="p-3">{{ $est->name }}</td>
                            <td class="p-3">{{ $est->email }}</td>
                            <td class="p-3">{{ $est->documentos_count }}</td>
                            <td class="p-3">
                                <a href="{{ route('tutor.estudiantes.show', $est->id) }}"
                                    class="text-blue-600 hover:underline">Ver Detalles</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">No hay estudiantes asignados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

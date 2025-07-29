@extends('layouts.app')

@section('title', 'Dashboard Tutor Académico')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Estudiantes Asignados</h1>

        @if ($estudiantes->count() > 0)
            <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-6 text-left">#</th>
                        <th class="py-3 px-6 text-left">Nombre</th>
                        <th class="py-3 px-6 text-left">Correo Electrónico</th>
                        <th class="py-3 px-6 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estudiantes as $index => $estudiante)
                        <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : '' }}">
                            <td class="py-3 px-6">{{ $estudiantes->firstItem() + $index }}</td>
                            <td class="py-3 px-6">{{ $estudiante->name }}</td>
                            <td class="py-3 px-6">{{ $estudiante->email }}</td>
                            <td class="py-3 px-6">
                                <a href="{{ route('tutor.estudiantes.show', $estudiante->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Ver Detalles
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $estudiantes->links() }}
            </div>
        @else
            <p>No tienes estudiantes asignados aún.</p>
        @endif
    </div>
@endsection

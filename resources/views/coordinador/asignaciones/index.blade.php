@extends('layouts.app')

@section('title', 'Asignaciones de Estudiantes')

@section('content')
    <div class="max-w-6xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-2xl font-semibold mb-4">Asignaciones de Estudiantes</h2>

        <a href="{{ route('coordinador.asignaciones.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block">
            + Nueva Asignación
        </a>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-2 text-left">Estudiante</th>
                    <th class="px-4 py-2 text-left">Plaza / Empresa</th>
                    <th class="px-4 py-2 text-left">Supervisor</th>
                    <th class="px-4 py-2 text-left">Estado</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($asignaciones as $asignacion)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $asignacion->estudiante->name }}</td>
                        <td class="px-4 py-2">{{ $asignacion->plaza->area_practica }} /
                            {{ $asignacion->plaza->empresa->nombre }}</td>
                        <td class="px-4 py-2">{{ $asignacion->supervisor?->name ?? 'Sin asignar' }}</td>
                        <td class="px-4 py-2 capitalize">{{ $asignacion->estado }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('coordinador.asignaciones.show', $asignacion) }}"
                                class="text-blue-600 hover:underline">Ver</a>
                            <form action="{{ route('coordinador.asignaciones.destroy', $asignacion) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                    onclick="return confirm('¿Eliminar esta asignación?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $asignaciones->links() }}
        </div>
    </div>
@endsection

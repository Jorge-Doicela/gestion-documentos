@extends('layouts.app')

@section('title', 'Detalle Estudiante')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Detalle del Estudiante: {{ $estudiante->name }}</h1>

    <div class="mb-4">
        <p><strong>Email:</strong> {{ $estudiante->email }}</p>
        <p><strong>Asignado a Tutor:</strong> {{ $estudiante->tutor ? $estudiante->tutor->name : 'No asignado' }}</p>
    </div>

    <h2 class="text-xl font-semibold mb-4">Documentos del Estudiante</h2>

    @if ($documentos->count())
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Tipo de Documento</th>
                    <th class="border border-gray-300 px-4 py-2">Nombre Archivo</th>
                    <th class="border border-gray-300 px-4 py-2">Estado</th>
                    <th class="border border-gray-300 px-4 py-2">Fecha Subida</th>
                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentos as $doc)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $doc->tipoDocumento->nombre }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $doc->nombre_archivo }}</td>
                        <td class="border border-gray-300 px-4 py-2 capitalize">{{ str_replace('_', ' ', $doc->estado) }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $doc->created_at->format('d/m/Y') }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('tutor.revision.show', $doc->id) }}"
                                class="text-blue-600 hover:underline">Ver</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $documentos->links() }}
        </div>
    @else
        <p>Este estudiante no ha subido documentos aún.</p>
    @endif

    <a href="{{ route('tutor.dashboard') }}"
        class="inline-block mt-6 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
        ← Volver al Dashboard
    </a>
@endsection

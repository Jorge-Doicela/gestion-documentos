@extends('layouts.app')

@section('title', 'Mis Documentos')

@section('content')
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">📄 Mis Documentos</h1>

        <a href="{{ route('estudiante.documentos.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-4 inline-block">
            ➕ Subir nuevo documento
        </a>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($documentos->isEmpty())
            <p class="text-gray-600">No has subido ningún documento aún.</p>
        @else
            <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">Tipo de Documento</th>
                        <th class="py-2 px-4 text-left">Archivo</th>
                        <th class="py-2 px-4 text-left">Estado</th>
                        <th class="py-2 px-4 text-left">Comentarios</th>
                        <th class="py-2 px-4 text-left">Acciones</th>
                        <th class="py-2 px-4 text-left">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documentos as $doc)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4">{{ $doc->tipoDocumento->nombre }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ Storage::url($doc->ruta_archivo) }}" class="text-blue-600 underline"
                                    target="_blank">
                                    {{ $doc->nombre_archivo }}
                                </a>
                            </td>
                            <td class="py-2 px-4">
                                <span
                                    class="px-2 py-1 rounded text-white
                                    @if ($doc->estado === 'Pendiente') bg-yellow-500
                                    @elseif ($doc->estado === 'Aprobado') bg-green-600
                                    @else bg-red-600 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $doc->estado)) }}
                                </span>
                            </td>
                            <td class="py-2 px-4 text-sm">
                                @if ($doc->comentarios_json)
                                    <ul class="list-disc list-inside text-red-600">
                                        @foreach (json_decode($doc->comentarios_json, true) as $comentario)
                                            <li>{{ $comentario }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500">Sin comentarios</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                @if (in_array($doc->estado, ['rechazado', 'no_aprobado']))
                                    <a href="{{ route('estudiante.documentos.edit', $doc->id) }}"
                                        class="text-blue-600 hover:underline">
                                        Re-subir
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

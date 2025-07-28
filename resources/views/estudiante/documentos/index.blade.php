@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto p-4">
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

        <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="py-2 px-4 text-left">#</th>
                    <th class="py-2 px-4 text-left">Tipo</th>
                    <th class="py-2 px-4 text-left">Archivo</th>
                    <th class="py-2 px-4 text-left">Estado</th>
                    <th class="py-2 px-4 text-left">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documentos as $doc)
                    <tr class="border-t">
                        <td class="py-2 px-4">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4">{{ $doc->tipoDocumento->nombre }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ Storage::url($doc->ruta_archivo) }}" class="text-blue-600 underline"
                                target="_blank">Ver PDF</a>
                        </td>
                        <td class="py-2 px-4">
                            <span
                                class="px-2 py-1 rounded text-white
                            @if ($doc->estado == 'Pendiente') bg-yellow-500
                            @elseif($doc->estado == 'Aprobado') bg-green-600
                            @else bg-red-600 @endif">
                                {{ $doc->estado }}
                            </span>
                        </td>
                        <td class="py-2 px-4">{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">No has subido ningún documento aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Historial de Revisión')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">📜 Historial de Revisión de Documentos</h1>

        {{-- Formulario de filtros --}}
        <form method="GET" action="{{ route('tutor.historial.index') }}" class="mb-6 flex flex-wrap gap-4 items-end">

            {{-- Estado --}}
            <div>
                <label for="estado" class="block font-semibold mb-1">Estado</label>
                <select name="estado" id="estado" class="border rounded px-3 py-2">
                    <option value="">-- Todos --</option>
                    <option value="aprobado_tutor" {{ request('estado') == 'aprobado_tutor' ? 'selected' : '' }}>Aprobado
                    </option>
                    <option value="rechazado_tutor" {{ request('estado') == 'rechazado_tutor' ? 'selected' : '' }}>Rechazado
                    </option>
                    <option value="pendiente_tutor" {{ request('estado') == 'pendiente_tutor' ? 'selected' : '' }}>Pendiente
                    </option>
                </select>
            </div>

            {{-- Fecha inicio --}}
            <div>
                <label for="fecha_inicio" class="block font-semibold mb-1">Fecha inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}"
                    class="border rounded px-3 py-2" />
            </div>

            {{-- Fecha fin --}}
            <div>
                <label for="fecha_fin" class="block font-semibold mb-1">Fecha fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}"
                    class="border rounded px-3 py-2" />
            </div>

            {{-- Estudiante --}}
            <div>
                <label for="estudiante_id" class="block font-semibold mb-1">Estudiante</label>
                <select name="estudiante_id" id="estudiante_id" class="border rounded px-3 py-2">
                    <option value="">-- Todos --</option>
                    @foreach ($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id }}"
                            {{ request('estudiante_id') == $estudiante->id ? 'selected' : '' }}>
                            {{ $estudiante->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tipo de documento --}}
            <div>
                <label for="tipo_documento_id" class="block font-semibold mb-1">Tipo de Documento</label>
                <select name="tipo_documento_id" id="tipo_documento_id" class="border rounded px-3 py-2">
                    <option value="">-- Todos --</option>
                    @foreach ($tiposDocumento as $tipo)
                        <option value="{{ $tipo->id }}"
                            {{ request('tipo_documento_id') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Filtrar
                </button>
            </div>
        </form>

        {{-- Tabla de resultados --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg shadow">
                <thead class="bg-gray-100 text-left text-sm font-medium">
                    <tr>
                        <th class="px-4 py-2">Estudiante</th>
                        <th class="px-4 py-2">Documento</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Revisado el</th>
                        <th class="px-4 py-2">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documentos as $documento)
                        <tr class="border-b hover:bg-gray-50 text-sm">
                            <td class="px-4 py-2">{{ $documento->usuario->name }}</td>
                            <td class="px-4 py-2">{{ $documento->tipoDocumento->nombre }}</td>
                            <td class="px-4 py-2">
                                @if ($documento->estado === 'aprobado_tutor')
                                    <span class="text-green-600 font-semibold">Aprobado</span>
                                @elseif ($documento->estado === 'rechazado_tutor')
                                    <span class="text-red-600 font-semibold">Rechazado</span>
                                @elseif ($documento->estado === 'pendiente_tutor')
                                    <span class="text-yellow-600 font-semibold">Pendiente</span>
                                @else
                                    <span class="text-gray-500">Otro</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                {{ optional($documento->fecha_revision)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('tutor.revision_documentos.show', $documento->id) }}"
                                    class="text-blue-600 hover:underline">
                                    Ver detalles
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                No hay documentos revisados que coincidan con los filtros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $documentos->links() }}
        </div>
    </div>
@endsection

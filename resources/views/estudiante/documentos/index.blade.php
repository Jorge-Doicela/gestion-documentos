@extends('layouts.app')

@section('title', 'Mis Documentos')
@php
    function iconoComentario($tipo)
    {
        return match ($tipo) {
            'error' => '❌',
            'sugerencia' => '💡',
            'observacion' => '📝',
            default => '🔹',
        };
    }
@endphp

@section('content')
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">📄 Mis Documentos de Prácticas</h1>

        <a href="{{ route('estudiante.documentos.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-6 inline-block">
            ➕ Subir nuevo documento
        </a>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($listaDocumentos->isEmpty())
            <p class="text-gray-600">No tienes documentos disponibles.</p>
        @else
            <table class="min-w-full table-auto border-collapse border border-gray-300 shadow rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Tipo de Documento</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Estado</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Comentarios</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Archivo</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Fecha de Revisión</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listaDocumentos as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $item['tipo_documento']->nombre }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @switch($item['estado'])
                                    @case('pendiente')
                                        <span class="text-yellow-600 font-semibold">Pendiente</span>
                                    @break

                                    @case('no_aprobado')
                                        <span class="text-red-600 font-semibold">No aprobado</span>
                                    @break

                                    @case('rechazado')
                                        <span class="text-red-600 font-semibold">Rechazado</span>
                                    @break

                                    @case('aprobado_tutor')
                                        <span class="text-yellow-600 font-semibold">Aprobado por Tutor</span>
                                    @break

                                    @case('aprobado_final')
                                        <span class="text-green-600 font-semibold">Aprobado Final</span>
                                    @break

                                    @default
                                        <span>{{ ucfirst($item['estado'] ?? 'Desconocido') }}</span>
                                @endswitch
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">





                                @if ($item['comentarios']->isNotEmpty())
                                    @php
                                        $comentariosAgrupados = $item['comentarios']->groupBy('seccion');
                                    @endphp

                                    <div class="space-y-4">
                                        @foreach ($comentariosAgrupados as $seccion => $comentarios)
                                            <div class="bg-white border-l-4 border-blue-500 shadow-sm rounded-lg p-4">
                                                <h3 class="text-lg font-semibold text-blue-700 mb-2">
                                                    📌 Sección: {{ ucfirst($seccion) }}
                                                </h3>

                                                <ul class="space-y-2">
                                                    @foreach ($comentarios as $comentario)
                                                        @php
                                                            $icon = match ($comentario->tipo) {
                                                                'error' => '❌',
                                                                'sugerencia' => '💡',
                                                                'observacion' => '📝',
                                                                default => '🔹',
                                                            };

                                                            $color = match ($comentario->tipo) {
                                                                'error' => 'text-red-600',
                                                                'sugerencia' => 'text-yellow-600',
                                                                'observacion' => 'text-green-600',
                                                                default => 'text-gray-600',
                                                            };

                                                            $rol =
                                                                $comentario->usuario->getRoleNames()->first() ??
                                                                'Desconocido';
                                                        @endphp

                                                        <li class="bg-gray-50 border border-gray-200 rounded p-3">
                                                            <p class="text-sm {{ $color }} font-medium">
                                                                {{ $icon }} {{ ucfirst($comentario->tipo) }}
                                                            </p>
                                                            <p class="text-gray-800 text-sm mt-1">
                                                                {{ $comentario->mensaje }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 mt-2">
                                                                — {{ $comentario->usuario->name }} ({{ ucfirst($rol) }})
                                                            </p>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500 italic">No hay comentarios registrados.</div>
                                @endif




                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if ($item['ruta_archivo'])
                                    <a href="{{ Storage::url($item['ruta_archivo']) }}" target="_blank"
                                        class="text-blue-600 underline">Ver PDF</a>
                                @else
                                    <span class="text-gray-400">Sin archivo</span>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $item['fecha_revision'] ? \Carbon\Carbon::parse($item['fecha_revision'])->format('d/m/Y H:i') : 'Sin revisión' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if (in_array($item['estado'], ['rechazado', 'no_aprobado']))
                                    <a href="{{ route('estudiante.documentos.edit', $item['documento_id']) }}"
                                        class="text-blue-600 hover:underline">
                                        Re-subir
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    @if ($certificado)
        <div class="mt-6 p-4 border rounded bg-green-50">
            <h2 class="font-semibold text-lg mb-2">🎉 Certificado disponible</h2>
            <p>Emitido el: {{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }}</p>
            <a href="{{ route('estudiante.certificado.descargar', $certificado->uuid) }}"
                class="mt-3 inline-block bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                Descargar Certificado
            </a>
        </div>
    @endif

@endsection

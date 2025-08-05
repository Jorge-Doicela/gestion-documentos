@extends('layouts.app')

@section('title', 'Detalle Documento')

@section('content')
    <div class="max-w-4xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Detalle del Documento: {{ $documento->tipoDocumento->nombre }}</h1>

        <div class="mb-4">
            <strong>Estado:</strong>
            @switch($documento->estado)
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
                    <span>{{ ucfirst($documento->estado) }}</span>
            @endswitch
        </div>

        <div class="mb-4">
            <strong>Archivo:</strong>
            @if ($documento->ruta_archivo && Storage::exists($documento->ruta_archivo))
                <a href="{{ Storage::url($documento->ruta_archivo) }}" target="_blank" class="text-blue-600 underline">Ver
                    PDF</a>
            @else
                <span class="text-gray-400">Archivo no disponible</span>
            @endif
        </div>

        <div class="mb-4">
            <strong>Comentarios:</strong>
            @if ($comentarios->isNotEmpty())
                @php
                    $comentariosAgrupados = $comentarios->groupBy('seccion');
                @endphp

                <div class="space-y-4">
                    @foreach ($comentariosAgrupados as $seccion => $comentariosSeccion)
                        <div class="bg-white border-l-4 border-blue-500 shadow-sm rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-blue-700 mb-2">
                                📌 Sección: {{ ucfirst($seccion) }}
                            </h3>

                            <ul class="space-y-2">
                                @foreach ($comentariosSeccion as $comentario)
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

                                        $rol = $comentario->usuario->getRoleNames()->first() ?? 'Desconocido';
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
        </div>

        <a href="{{ route('estudiante.documentos.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">
            ← Volver a la lista
        </a>
    </div>
@endsection

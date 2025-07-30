{{-- resources/views/coordinador/documentos/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Documentos Aprobados por Tutores</h2>

        @if ($documentos->isEmpty())
            <p>No hay documentos disponibles por revisar.</p>
        @else
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-2">Estudiante</th>
                        <th class="text-left p-2">Tipo</th>
                        <th class="text-left p-2">Archivo</th>
                        <th class="text-left p-2">Subido</th>
                        <th class="text-left p-2">Observaciones</th>
                        <th class="text-left p-2">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documentos as $doc)
                        <tr class="border-b align-top">
                            <td class="p-2">{{ $doc->estudiante->name }}</td>
                            <td class="p-2">{{ $doc->tipoDocumento->nombre }}</td>
                            <td class="p-2">
                                <a href="{{ asset('storage/' . $doc->ruta_archivo) }}" target="_blank"
                                    class="text-blue-500 hover:underline">Ver PDF</a>
                            </td>
                            <td class="p-2">{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-2">
                                @if ($doc->comentarios_json)
                                    <div class="text-xs text-gray-700 whitespace-pre-wrap">
                                        {{ json_decode($doc->comentarios_json)->coordinador ?? 'Sin observaciones' }}
                                    </div>
                                @else
                                    <span class="text-gray-500 text-xs">Sin observaciones</span>
                                @endif
                            </td>
                            <td class="p-2">
                                <form action="{{ route('coordinador.documentos.update', $doc->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="observacion" rows="2" placeholder="Agregar observación..."
                                        class="border rounded w-full text-xs mb-1">{{ json_decode($doc->comentarios_json)->coordinador ?? '' }}</textarea>
                                    <div class="flex gap-2">
                                        <button type="submit" name="accion" value="aprobar"
                                            class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600">
                                            Aprobar
                                        </button>
                                        <button type="submit" name="accion" value="rechazar"
                                            class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">
                                            Rechazar
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

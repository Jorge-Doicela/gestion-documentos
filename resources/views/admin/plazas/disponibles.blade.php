@extends('layouts.app')

@section('title', 'Plazas Disponibles')

@section('content')
    <div class="container mx-auto p-4">

        <h1 class="text-2xl font-bold mb-4">Plazas Disponibles</h1>

        @if ($plazas->count() > 0)
            <table class="min-w-full bg-white border border-gray-200 rounded">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">Empresa</th>
                        <th class="py-2 px-4 border-b">Área de Práctica</th>
                        <th class="py-2 px-4 border-b">Período Académico</th>
                        <th class="py-2 px-4 border-b">Carrera</th>
                        <th class="py-2 px-4 border-b">Habilidades</th>
                        <th class="py-2 px-4 border-b">Documentos previos</th>
                        <th class="py-2 px-4 border-b">Vacantes</th>
                        <th class="py-2 px-4 border-b">Fechas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plazas as $plaza)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $plaza->empresa->nombre }}</td>
                            <td class="py-2 px-4 border-b">{{ $plaza->area_practica }}</td>
                            <td class="py-2 px-4 border-b">{{ $plaza->periodo_academico }}</td>
                            <td class="py-2 px-4 border-b">{{ $plaza->carrera }}</td>
                            <td class="py-2 px-4 border-b">{{ $plaza->habilidades_requeridas ?? '-' }}</td>
                            <td class="py-2 px-4 border-b">
                                @if ($plaza->documentos_previos)
                                    @foreach (json_decode($plaza->documentos_previos) as $doc)
                                        <span
                                            class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded mr-1">{{ $doc }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b">{{ $plaza->vacantes }}</td>
                            <td class="py-2 px-4 border-b">
                                {{ $plaza->fecha_inicio }} - {{ $plaza->fecha_fin }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $plazas->links() }}
            </div>
        @else
            <p>No hay plazas disponibles para tu carrera en este período.</p>
        @endif
    </div>
@endsection

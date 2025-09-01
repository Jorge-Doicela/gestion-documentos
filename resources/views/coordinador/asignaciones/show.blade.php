@extends('layouts.app')

@section('title', 'Detalle de Asignación')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-2xl font-semibold mb-4">Detalle de Asignación</h2>

        <div class="mb-4">
            <strong>Estudiante:</strong> {{ $asignacion->estudiante->name }} ({{ $asignacion->estudiante->email }})
        </div>
        <div class="mb-4">
            <strong>Plaza:</strong> {{ $asignacion->plaza->area_practica }} / {{ $asignacion->plaza->empresa->nombre }}
        </div>
        <div class="mb-4">
            <strong>Supervisor:</strong> {{ $asignacion->supervisor?->name ?? 'Sin asignar' }}
        </div>
        <div class="mb-4">
            <strong>Estado:</strong> {{ ucfirst($asignacion->estado) }}
        </div>

        @if ($asignacion->planTrabajo)
            <div class="mt-6 p-4 border rounded bg-gray-50">
                <h3 class="text-xl font-semibold mb-2">Plan de Trabajo</h3>
                <div class="mb-2">
                    <strong>Objetivos:</strong>
                    <p>{{ $asignacion->planTrabajo->objetivos ?? '-' }}</p>
                </div>
                <div class="mb-2">
                    <strong>Actividades:</strong>
                    <p>{{ $asignacion->planTrabajo->actividades ?? '-' }}</p>
                </div>
                <div class="mb-2">
                    <strong>Fecha Inicio:</strong> {{ $asignacion->planTrabajo->fecha_inicio->format('d/m/Y') }}
                </div>
                <div class="mb-2">
                    <strong>Fecha Fin:</strong> {{ $asignacion->planTrabajo->fecha_fin->format('d/m/Y') }}
                </div>
            </div>
        @endif
    </div>
@endsection

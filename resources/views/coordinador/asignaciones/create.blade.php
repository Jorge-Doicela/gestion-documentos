@extends('layouts.app')

@section('title', 'Nueva Asignación')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-2xl font-semibold mb-4">Asignar Estudiante a Plaza</h2>

        <form action="{{ route('coordinador.asignaciones.store') }}" method="POST">
            @csrf

            {{-- Plaza --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Plaza</label>
                <select name="plaza_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Seleccione Plaza --</option>
                    @foreach ($plazas as $plaza)
                        <option value="{{ $plaza->id }}">
                            {{ $plaza->area_practica }} - {{ $plaza->empresa->nombre }} ({{ $plaza->vacantes }} vacantes)
                        </option>
                    @endforeach
                </select>
                @error('plaza_id')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Estudiante --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Estudiante</label>
                <select name="estudiante_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Seleccione Estudiante --</option>
                    @foreach ($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id }}">{{ $estudiante->name }} ({{ $estudiante->email }})</option>
                    @endforeach
                </select>
                @error('estudiante_id')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Supervisor --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Supervisor (opcional)</label>
                <select name="supervisor_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Ninguno --</option>
                    @foreach ($supervisores as $supervisor)
                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                    @endforeach
                </select>
                @error('supervisor_id')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Plan de trabajo --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Objetivos</label>
                <textarea name="objetivos" class="w-full border rounded px-3 py-2">{{ old('objetivos') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Actividades</label>
                <textarea name="actividades" class="w-full border rounded px-3 py-2">{{ old('actividades') }}</textarea>
            </div>

            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                        class="w-full border rounded px-3 py-2">
                    @error('fecha_inicio')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block font-medium mb-1">Fecha Fin</label>
                    <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}"
                        class="w-full border rounded px-3 py-2">
                    @error('fecha_fin')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Guardar Asignación
            </button>
        </form>
    </div>
@endsection

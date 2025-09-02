@extends('layouts.app')

@section('title', 'Plazas de Práctica')

@section('content')
    <div class="container mx-auto p-4">

        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Listado de Plazas</h1>
            <a href="{{ route('admin.plazas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Nueva Plaza
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario de filtros --}}
        <form method="GET" class="mb-4 flex gap-2 flex-wrap">
            <select name="empresa_id" class="border rounded px-2 py-1">
                <option value="">Todas las empresas</option>
                @foreach ($empresas as $empresa)
                    <option value="{{ $empresa->id }}" {{ request('empresa_id') == $empresa->id ? 'selected' : '' }}>
                        {{ $empresa->nombre }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="carrera" placeholder="Carrera" value="{{ request('carrera') }}"
                class="border rounded px-2 py-1">
            <input type="text" name="periodo_academico" placeholder="Período Académico"
                value="{{ request('periodo_academico') }}" class="border rounded px-2 py-1">

            <label class="flex items-center gap-1">
                <input type="checkbox" name="vigentes" value="1" {{ request('vigentes') ? 'checked' : '' }}>
                Vigentes
            </label>

            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Filtrar</button>
        </form>

        <div class="flex justify-end gap-2 mb-4">
            <a href="{{ route('admin.plazas.export.excel', request()->query()) }}"
                class="bg-green-500 text-white px-4 py-2 rounded">Exportar Excel</a>
            <a href="{{ route('admin.plazas.export.pdf', request()->query()) }}"
                class="bg-red-500 text-white px-4 py-2 rounded">Exportar PDF</a>
        </div>


        {{-- Tabla de plazas --}}
        <table class="min-w-full bg-white border border-gray-200 rounded">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">Empresa</th>
                    <th class="py-2 px-4 border-b">Área</th>
                    <th class="py-2 px-4 border-b">Período</th>
                    <th class="py-2 px-4 border-b">Carrera</th>
                    <th class="py-2 px-4 border-b">Vacantes</th>
                    <th class="py-2 px-4 border-b">Fechas</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plazas as $plaza)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $plaza->empresa->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $plaza->area_practica }}</td>
                        <td class="py-2 px-4 border-b">{{ $plaza->periodo_academico }}</td>
                        <td class="py-2 px-4 border-b">{{ $plaza->carrera }}</td>
                        <td class="py-2 px-4 border-b">{{ $plaza->vacantes }}</td>
                        <td class="py-2 px-4 border-b">{{ $plaza->fecha_inicio }} - {{ $plaza->fecha_fin }}</td>
                        <td class="py-2 px-4 border-b flex gap-2">
                            <a href="{{ route('admin.plazas.edit', $plaza) }}"
                                class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</a>
                            <form action="{{ route('admin.plazas.destroy', $plaza) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar plaza?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $plazas->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

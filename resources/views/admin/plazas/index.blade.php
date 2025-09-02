@extends('layouts.app')

@section('title', 'Plazas de Práctica')

@section('content')
    <div class="container-custom py-6 px-4 sm:px-6 lg:px-8 animate-fade-in">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-3xl font-display font-bold text-institutional-dark mb-4 md:mb-0 text-gradient-istpet">
                💼 Listado de Plazas
            </h1>
            <a href="{{ route('admin.plazas.create') }}"
                class="btn-primary inline-flex items-center gap-2 animate-pulse-border">
                <i class="fas fa-plus"></i> Nueva Plaza
            </a>
        </div>

        @if (session('success'))
            <div
                class="p-4 mb-6 rounded-lg shadow-soft-lg animate-slide-in-right bg-success/20 text-success font-semibold border-l-4 border-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="glass-dark p-6 rounded-lg mb-6 animate-fade-in-down">
            <form method="GET" class="flex flex-wrap gap-4 items-end" aria-label="Filtrar plazas">
                <select name="empresa_id"
                    class="border border-steel rounded-lg px-3 py-2 w-full md:w-48 shadow-sm focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800">
                    <option value="">Todas las empresas</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ request('empresa_id') == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="carrera" placeholder="Carrera" value="{{ request('carrera') }}"
                    class="border border-steel rounded-lg px-3 py-2 w-full md:w-48 shadow-sm focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800">

                <input type="text" name="periodo_academico" placeholder="Período Académico"
                    value="{{ request('periodo_academico') }}"
                    class="border border-steel rounded-lg px-3 py-2 w-full md:w-48 shadow-sm focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800">

                <label class="flex items-center gap-2 font-semibold text-institutional-dark">
                    <input type="checkbox" name="vigentes" value="1" {{ request('vigentes') ? 'checked' : '' }}
                        class="w-4 h-4 accent-institutional rounded-sm focus:ring-2 focus:ring-gold-dark">
                    Vigentes
                </label>

                <button type="submit" class="btn-secondary inline-flex items-center gap-1">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </form>

            <div class="flex flex-wrap gap-2 justify-end mt-4">
                <a href="{{ route('admin.plazas.export.excel', request()->query()) }}"
                    class="bg-eco hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-soft-lg transition flex items-center gap-1">
                    <i class="fas fa-file-excel"></i> Exportar Excel
                </a>
                <a href="{{ route('admin.plazas.export.pdf', request()->query()) }}"
                    class="bg-danger hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-soft-lg transition flex items-center gap-1">
                    <i class="fas fa-file-pdf"></i> Exportar PDF
                </a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-steel-light shadow-soft-lg md:block hidden animate-scale-in">
            <table class="min-w-full divide-y divide-steel text-gray-700 text-sm">
                <thead class="bg-institutional-light text-white uppercase text-xs tracking-wider">
                    <tr>
                        <th class="py-3 px-4 text-left">Empresa</th>
                        <th class="py-3 px-4 text-left">Área</th>
                        <th class="py-3 px-4 text-left">Período</th>
                        <th class="py-3 px-4 text-left">Carrera</th>
                        <th class="py-3 px-4 text-left">Vacantes</th>
                        <th class="py-3 px-4 text-left">Fechas</th>
                        <th class="py-3 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($plazas as $plaza)
                        <tr class="hover:bg-gray-50 transition duration-400">
                            <td class="py-2 px-4 font-semibold text-institutional">{{ $plaza->empresa->nombre }}</td>
                            <td class="py-2 px-4">{{ $plaza->area_practica }}</td>
                            <td class="py-2 px-4">{{ $plaza->periodo_academico }}</td>
                            <td class="py-2 px-4">{{ $plaza->carrera }}</td>
                            <td class="py-2 px-4 text-center">
                                <span
                                    class="inline-block px-2 py-1 rounded-full text-xs font-bold text-white
                                @if ($plaza->vacantes > 5) bg-success @elseif($plaza->vacantes > 2) bg-warning @else bg-danger @endif">
                                    {{ $plaza->vacantes }}
                                </span>
                            </td>
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($plaza->fecha_inicio)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($plaza->fecha_fin)->format('d/m/Y') }}</td>
                            <td class="py-2 px-4 flex gap-2">
                                <a href="{{ route('admin.plazas.edit', $plaza) }}"
                                    class="bg-warning hover:bg-yellow-600 text-white px-2 py-1 rounded-lg shadow-md transition flex items-center gap-1"
                                    title="Editar Plaza">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('admin.plazas.destroy', $plaza) }}" method="POST"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta plaza? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-danger hover:bg-red-700 text-white px-2 py-1 rounded-lg shadow-md transition flex items-center gap-1"
                                        title="Eliminar Plaza">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-4 text-center text-gray-500">
                                ⚠️ No se encontraron plazas de práctica.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="md:hidden mt-4 space-y-4 animate-fade-in-up">
            @forelse ($plazas as $plaza)
                <div class="bg-white rounded-lg p-4 space-y-2 card-hover">
                    <h2 class="font-display font-bold text-lg text-institutional-dark">{{ $plaza->empresa->nombre }}</h2>
                    <p class="text-sm"><span class="font-semibold text-institutional">Área:</span>
                        {{ $plaza->area_practica }}</p>
                    <p class="text-sm"><span class="font-semibold text-institutional">Período:</span>
                        {{ $plaza->periodo_academico }}</p>
                    <p class="text-sm"><span class="font-semibold text-institutional">Carrera:</span> {{ $plaza->carrera }}
                    </p>
                    <p class="text-sm">
                        <span class="font-semibold text-institutional">Vacantes:</span>
                        <span
                            class="inline-block px-2 py-1 rounded-full text-xs font-bold text-white
                        @if ($plaza->vacantes > 5) bg-success @elseif($plaza->vacantes > 2) bg-warning @else bg-danger @endif">
                            {{ $plaza->vacantes }}
                        </span>
                    </p>
                    <p class="text-sm"><span class="font-semibold text-institutional">Fechas:</span>
                        {{ \Carbon\Carbon::parse($plaza->fecha_inicio)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($plaza->fecha_fin)->format('d/m/Y') }}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <a href="{{ route('admin.plazas.edit', $plaza) }}"
                            class="bg-warning text-white px-3 py-1 rounded-lg shadow-md transition hover:bg-yellow-600 flex items-center gap-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('admin.plazas.destroy', $plaza) }}" method="POST"
                            onsubmit="return confirm('¿Está seguro de eliminar esta plaza? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-danger text-white px-3 py-1 rounded-lg shadow-md transition hover:bg-red-700 flex items-center gap-1">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-soft-lg p-6 text-center text-gray-500">
                    ⚠️ No se encontraron plazas de práctica.
                </div>
            @endforelse
        </div>

        <div class="mt-6 animate-fade-in-up">
            {{ $plazas->appends(request()->query())->links() }}
        </div>

    </div>
@endsection

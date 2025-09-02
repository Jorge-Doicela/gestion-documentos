@extends('layouts.app')

@section('title', 'Empresas')

@section('content')
    <div class="container-custom py-6 px-4 sm:px-6 lg:px-8 animate-fade-in">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-3xl font-display font-bold text-institutional-dark mb-4 md:mb-0 text-gradient-istpet">
                🏢 Listado de Empresas
            </h1>
            <a href="{{ route('admin.empresas.create') }}"
                class="btn-primary inline-flex items-center gap-2 animate-pulse-border">
                <i class="fas fa-plus"></i> Nueva Empresa
            </a>
        </div>

        @if (session('success'))
            <div
                class="p-4 mb-6 rounded-lg shadow-soft-lg animate-slide-in-right bg-success/20 text-success font-semibold border-l-4 border-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="glass-dark p-6 rounded-lg mb-6 animate-fade-in-down">
            <form method="GET" class="flex flex-wrap gap-4 items-end" aria-label="Filtrar empresas">
                <input type="text" name="nombre" placeholder="Nombre" value="{{ request('nombre') }}"
                    class="border border-steel rounded-lg px-3 py-2 w-full md:w-48 shadow-sm focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800">
                <input type="text" name="ruc" placeholder="RUC" value="{{ request('ruc') }}"
                    class="border border-steel rounded-lg px-3 py-2 w-full md:w-48 shadow-sm focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800">
                <button type="submit" class="btn-secondary inline-flex items-center gap-1">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </form>

            <div class="flex flex-wrap gap-2 justify-end mt-4">
                <a href="{{ route('admin.empresas.export.excel') }}"
                    class="bg-eco hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-soft-lg transition flex items-center gap-1">
                    <i class="fas fa-file-excel"></i> Exportar Excel
                </a>
                <a href="{{ route('admin.empresas.export.pdf') }}"
                    class="bg-danger hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-soft-lg transition flex items-center gap-1">
                    <i class="fas fa-file-pdf"></i> Exportar PDF
                </a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-steel-light shadow-soft-lg md:block hidden animate-scale-in">
            <table class="min-w-full divide-y divide-steel text-gray-700 text-sm">
                <thead class="bg-institutional-light text-white uppercase text-xs tracking-wider">
                    <tr>
                        <th class="py-3 px-4 text-left">Nombre</th>
                        <th class="py-3 px-4 text-left">RUC</th>
                        <th class="py-3 px-4 text-left">Teléfono</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Contacto</th>
                        <th class="py-3 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($empresas as $empresa)
                        <tr class="hover:bg-gray-50 transition duration-400">
                            <td class="py-2 px-4 font-semibold text-institutional">{{ $empresa->nombre }}</td>
                            <td class="py-2 px-4">{{ $empresa->ruc }}</td>
                            <td class="py-2 px-4">{{ $empresa->telefono }}</td>
                            <td class="py-2 px-4">{{ $empresa->email }}</td>
                            <td class="py-2 px-4">{{ $empresa->contacto }}</td>
                            <td class="py-2 px-4 flex gap-2">
                                <a href="{{ route('admin.empresas.edit', $empresa) }}"
                                    class="bg-warning hover:bg-yellow-600 text-white px-2 py-1 rounded-lg shadow-md transition flex items-center gap-1"
                                    title="Editar Empresa">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('admin.empresas.destroy', $empresa) }}" method="POST"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta empresa? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-danger hover:bg-red-700 text-white px-2 py-1 rounded-lg shadow-md transition flex items-center gap-1"
                                        title="Eliminar Empresa">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-gray-500">
                                ⚠️ No se encontraron empresas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="md:hidden mt-4 space-y-4 animate-fade-in-up">
            @forelse ($empresas as $empresa)
                <div class="bg-white rounded-lg p-4 space-y-2 card-hover">
                    <h2 class="font-display font-bold text-lg text-institutional-dark">{{ $empresa->nombre }}</h2>
                    <p class="text-sm"><span class="font-semibold text-institutional">RUC:</span> {{ $empresa->ruc }}</p>
                    <p class="text-sm"><span class="font-semibold text-institutional">Teléfono:</span>
                        {{ $empresa->telefono }}</p>
                    <p class="text-sm"><span class="font-semibold text-institutional">Email:</span> {{ $empresa->email }}
                    </p>
                    <p class="text-sm"><span class="font-semibold text-institutional">Contacto:</span>
                        {{ $empresa->contacto }}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <a href="{{ route('admin.empresas.edit', $empresa) }}"
                            class="bg-warning text-white px-3 py-1 rounded-lg shadow-md transition hover:bg-yellow-600 flex items-center gap-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('admin.empresas.destroy', $empresa) }}" method="POST"
                            onsubmit="return confirm('¿Está seguro de eliminar esta empresa? Esta acción no se puede deshacer.');">
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
                    ⚠️ No se encontraron empresas.
                </div>
            @endforelse
        </div>

        <div class="mt-6 animate-fade-in-up">
            {{ $empresas->appends(request()->query())->links() }}
        </div>

    </div>
@endsection

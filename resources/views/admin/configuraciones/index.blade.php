@extends('layouts.app')

@section('header')
    <h1 class="font-display font-bold text-4xl text-institutional-dark leading-tight animate-fade-in-up">
        ⚙️ Configuraciones Globales
    </h1>
@endsection

@section('content')
    <div x-data="{ open: false, configToDelete: null }" class="container-custom py-8 animate-fade-in">

        {{-- Header y botón de crear --}}
        <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
            <h2 class="text-3xl font-bold font-merriweather text-institutional-dark">Listado de Configuraciones</h2>
            <a href="{{ route('admin.configuraciones.create') }}" class="btn-primary-info"
                aria-label="Crear nueva configuración">
                <i class="fas fa-plus"></i> Nueva Configuración
            </a>
        </div>

        {{-- Mensaje de feedback --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg shadow-md animate-fade-in bg-success-light text-success" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Formulario de búsqueda --}}
        <form method="GET" action="{{ route('admin.configuraciones.index') }}"
            class="mb-6 flex flex-wrap gap-4 items-center" role="search" aria-label="Buscar configuraciones">
            <div class="flex-grow">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="🔍 Buscar por clave o descripción"
                    class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold focus:border-gold transition duration-400"
                    aria-label="Buscar configuraciones por clave o descripción" />
            </div>
            <button type="submit" class="btn-primary-gold">
                <i class="fas fa-search"></i> Buscar
            </button>
            @if (request('search'))
                <a href="{{ route('admin.configuraciones.index') }}" class="btn-secondary">
                    <i class="fas fa-times"></i> Limpiar
                </a>
            @endif
        </form>

        {{-- Contenido principal --}}
        @if ($configuraciones->count())
            {{-- Tabla de escritorio --}}
            <div class="overflow-x-auto bg-white rounded-2xl shadow-soft-lg animate-fade-in hidden md:block">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-steel" role="table"
                    aria-label="Listado de configuraciones globales">
                    <caption class="sr-only">Listado de configuraciones globales del sistema</caption>
                    <thead
                        class="bg-institutional-light uppercase text-xs tracking-wider font-semibold text-institutional-dark">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left">Clave</th>
                            <th scope="col" class="px-6 py-3 text-left">Valor</th>
                            <th scope="col" class="px-6 py-3 text-left">Descripción</th>
                            <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($configuraciones as $config)
                            <tr class="hover:bg-gray-50 transition duration-300">
                                <td class="px-6 py-4 font-mono font-medium text-institutional-dark">{{ $config->clave }}
                                </td>
                                <td class="px-6 py-4 break-words max-w-sm">
                                    {{ Str::length($config->valor) > 50 ? Str::limit($config->valor, 50) : $config->valor }}
                                </td>
                                <td class="px-6 py-4">{{ $config->descripcion }}</td>
                                <td class="px-6 py-4 text-center flex justify-center gap-2">
                                    <a href="{{ route('admin.configuraciones.edit', $config) }}"
                                        class="text-institutional hover:text-institutional-dark transition"
                                        title="Editar {{ $config->clave }}">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <button type="button" @click="open = true; configToDelete = {{ $config->id }};"
                                        class="text-danger hover:text-danger-dark transition"
                                        title="Eliminar {{ $config->clave }}">
                                        <i class="fas fa-trash fa-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tarjetas móviles --}}
            <div class="md:hidden space-y-4 animate-fade-in">
                @foreach ($configuraciones as $config)
                    <div
                        class="bg-white rounded-lg shadow-soft-md p-4 space-y-3 border-l-4 border-institutional-light hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-lg font-merriweather text-institutional-dark">{{ $config->clave }}
                            </h3>
                            <div class="flex gap-3">
                                <a href="{{ route('admin.configuraciones.edit', $config) }}"
                                    class="text-institutional hover:text-institutional-dark transition" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" @click="open = true; configToDelete = {{ $config->id }};"
                                    class="text-danger hover:text-danger-dark transition" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-steel">
                            <strong class="text-institutional-dark">Valor:</strong> {{ Str::limit($config->valor, 50) }}
                        </p>
                        <p class="text-steel text-sm">
                            <strong class="text-institutional-dark">Descripción:</strong> {{ $config->descripcion }}
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-6 flex justify-center animate-fade-in">
                {{ $configuraciones->links() }}
            </div>
        @else
            <div class="p-6 text-center bg-white rounded-2xl shadow-soft-lg animate-fade-in">
                <p class="text-gray-600 font-bold text-lg">⚠️ No se encontraron configuraciones.</p>
                <p class="text-gray-500 mt-2">Puedes crear una nueva configuración para empezar.</p>
            </div>
        @endif

        {{-- Modal de confirmación (rediseñado) --}}
        <div x-show="open" class="fixed inset-0 flex items-center justify-center p-4 z-50 transition-opacity duration-300"
            :class="{ 'opacity-100': open, 'opacity-0': !open }" style="display: none;" role="dialog" aria-modal="true"
            aria-labelledby="modal-title" aria-describedby="modal-desc" @keydown.escape.window="open = false">
            <div class="bg-gray-900 bg-opacity-75 absolute inset-0"></div>
            <div x-show="open" x-transition.duration.300ms
                class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm transform transition-transform duration-300 scale-95"
                @click.away="open = false" tabindex="-1" x-ref="modal" x-trap.noscroll="open">
                <h3 id="modal-title" class="text-2xl font-bold text-danger-dark mb-3">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Confirmar eliminación
                </h3>
                <p id="modal-desc" class="text-steel mb-6">
                    ¿Estás seguro de que quieres eliminar esta configuración?
                    <br><strong class="text-danger">Esta acción no se puede deshacer.</strong>
                </p>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="open = false" class="btn-secondary">
                        Cancelar
                    </button>
                    <form :action="`{{ url('admin/configuraciones') }}/${configToDelete}`" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-primary-danger">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

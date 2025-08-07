@extends('layouts.app')

@section('content')
    <div x-data="{ open: false, configToDelete: null }" class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Configuraciones Globales del Sistema</h1>
            <a href="{{ route('admin.configuraciones.create') }}"
                class="inline-block bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded shadow focus:outline-none focus:ring-2 focus:ring-blue-600"
                aria-label="Crear nueva configuración">
                + Nueva Configuración
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulario búsqueda -->
        <form method="GET" action="{{ route('admin.configuraciones.index') }}" class="mb-6" role="search"
            aria-label="Buscar configuraciones">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Buscar por clave o descripción" class="border rounded px-3 py-2 w-full md:w-1/2"
                aria-label="Buscar configuraciones por clave o descripción" />
        </form>

        @if ($configuraciones->count())
            <div class="overflow-x-auto bg-white rounded shadow border">
                <table class="w-full table-auto border" role="table" aria-label="Listado de configuraciones globales">
                    <caption class="sr-only">Listado de configuraciones globales del sistema</caption>
                    <thead>
                        <tr class="bg-gray-100">
                            <th scope="col" class="px-4 py-2 text-left font-semibold text-gray-700">Clave</th>
                            <th scope="col" class="px-4 py-2 font-semibold text-gray-700">Valor</th>
                            <th scope="col" class="px-4 py-2 font-semibold text-gray-700">Descripción</th>
                            <th scope="col" class="px-4 py-2 text-center font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($configuraciones as $config)
                            <tr class="border-t">
                                <td class="px-4 py-2 font-mono text-gray-900">{{ $config->clave }}</td>
                                <td class="px-4 py-2 break-words max-w-xs text-gray-800">
                                    @if (Str::length($config->valor) > 50)
                                        {{ Str::limit($config->valor, 50) }}
                                    @else
                                        {{ $config->valor }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $config->descripcion }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('admin.configuraciones.edit', $config) }}"
                                        class="text-blue-700 hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1"
                                        aria-label="Editar configuración {{ $config->clave }}">
                                        Editar
                                    </a>
                                    <button type="button"
                                        @click="open = true; configToDelete = {{ $config->id }}; $nextTick(() => $refs.modal.focus())"
                                        class="text-red-700 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 rounded px-1 ml-2"
                                        aria-label="Eliminar configuración {{ $config->clave }}">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $configuraciones->links() }}
            </div>
        @else
            <p class="text-gray-600">No se encontraron configuraciones.</p>
        @endif

        <!-- Modal para confirmación de eliminación -->
        <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
            style="display: none;" role="dialog" aria-modal="true" aria-labelledby="modal-title"
            aria-describedby="modal-desc" @keydown.escape.window="open = false">
            <div class="bg-white rounded shadow-lg p-6 max-w-md mx-auto" @click.away="open = false" tabindex="0"
                x-ref="modal" x-trap.noscroll="open">
                <h2 id="modal-title" class="text-lg font-semibold mb-4">Confirmar eliminación</h2>
                <p id="modal-desc" class="mb-6">¿Está seguro que desea eliminar esta configuración? Esta acción no se
                    puede deshacer.</p>

                <form :action="`{{ url('admin/configuraciones') }}/${configToDelete}`" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="open = false"
                            class="px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-400">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

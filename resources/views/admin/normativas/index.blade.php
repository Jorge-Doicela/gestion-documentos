@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Gestión de Normativas Documentales</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.normativas.create') }}"
            class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
            Nueva Normativa
        </a>

        <!-- FORMULARIO DE BÚSQUEDA -->
        <form action="{{ route('admin.normativas.index') }}" method="GET" class="mb-4 flex space-x-2">
            <input type="text" name="search" id="search" placeholder="Buscar por tipo o contenido"
                value="{{ old('search', $search ?? '') }}"
                class="flex-grow border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                Buscar
            </button>
            @if (!empty($search))
                <a href="{{ route('admin.normativas.index') }}"
                    class="ml-2 px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 text-gray-600">
                    Limpiar
                </a>
            @endif
        </form>

        @if ($normativas->count())
            <table class="min-w-full border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2 text-left">Tipo de Documento</th>
                        <th class="border px-4 py-2 text-left">Contenido</th>
                        <th class="border px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($normativas as $normativa)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 align-top">{{ $normativa->tipoDocumento->nombre }}</td>

                            <!-- Contenido con tooltip usando Tippy.js -->
                            <td class="border px-4 py-2 align-top">
                                <span data-tippy-content="{{ strip_tags($normativa->contenido) }}">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($normativa->contenido), 100) }}
                                </span>
                            </td>

                            <td class="border px-4 py-2 text-center align-top space-x-2">
                                <!-- Botón Editar -->
                                <a href="{{ route('admin.normativas.edit', $normativa) }}"
                                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                                    aria-label="Editar normativa">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5h6m-3 0v6m-6 4l7-7 3 3-7 7H5v-3z" />
                                    </svg>
                                    Editar
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('admin.normativas.destroy', $normativa) }}" method="POST"
                                    class="inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-300"
                                        aria-label="Eliminar normativa">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 011-1h2a1 1 0 011 1m-4 0h4" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $normativas->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <p class="text-gray-600">No hay normativas registradas.</p>
        @endif
    </div>
@endsection

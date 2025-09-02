@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Tipos de Documento</h1>
            @if (!isset($readonly) || !$readonly)
                <a href="{{ route('admin.tipos-documento.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Nuevo Tipo
                </a>
            @endif
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario de filtro --}}
        <form method="GET" action="{{ route('admin.tipos-documento.index') }}" class="mb-4 flex gap-2 items-center">
            <input type="text" name="search" placeholder="Buscar por nombre..." value="{{ request('search') }}"
                class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />

            <select name="obligatorio"
                class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                <option value="">Todos</option>
                <option value="1" {{ request('obligatorio') === '1' ? 'selected' : '' }}>Obligatorios</option>
                <option value="0" {{ request('obligatorio') === '0' ? 'selected' : '' }}>No Obligatorios</option>
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filtrar</button>
            <a href="{{ route('admin.tipos-documento.index') }}" class="text-gray-600 underline ml-2">Limpiar</a>
        </form>

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-2">#</th>
                        <th class="text-left px-4 py-2">Nombre</th>
                        <th class="text-left px-4 py-2">Descripción</th>
                        <th class="text-left px-4 py-2">Ejemplo</th>
                        <th class="text-left px-4 py-2">Obligatorio</th>
                        <th class="text-left px-4 py-2">Orden</th>
                        <th class="text-left px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tipos as $tipo)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $tipo->nombre }}</td>
                            <td class="px-4 py-2 text-gray-700">
                                {{ $tipo->descripcion ? Str::limit($tipo->descripcion, 80) : '—' }}
                            </td>
                            <td class="px-4 py-2">
                                @if ($tipo->archivo_ejemplo)
                                    <a href="{{ route('admin.tipos-documento.view', $tipo->id) }}"
                                        class="text-blue-600 underline mr-2" target="_blank"
                                        rel="noopener noreferrer">Ver</a>

                                    <a href="{{ route('admin.tipos-documento.download', $tipo->id) }}"
                                        class="text-green-600 underline" target="_blank"
                                        rel="noopener noreferrer">Descargar</a>
                                @else
                                    <span class="text-gray-400 italic">Sin archivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if ($tipo->obligatorio)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5 text-green-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="ml-1 text-green-600 font-semibold">Sí</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span class="ml-1 text-gray-500">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $tipo->orden }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                @if (!isset($readonly) || !$readonly)
                                    <a href="{{ route('admin.tipos-documento.edit', $tipo->id) }}"
                                        class="text-blue-600 hover:underline">Editar</a>
                                    <form action="{{ route('admin.tipos-documento.destroy', $tipo->id) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar este tipo?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">Solo lectura</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay tipos definidos aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $tipos->links() }}
        </div>
    </div>
@endsection

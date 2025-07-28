{{-- resources/views/admin/tipos_documento/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Tipos de Documento</h1>
            <a href="{{ route('admin.tipos-documento.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Tipo
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-2">#</th>
                        <th class="text-left px-4 py-2">Nombre</th>
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
                            <td class="px-4 py-2">
                                @if ($tipo->obligatorio)
                                    <span class="text-green-600 font-semibold">Sí</span>
                                @else
                                    <span class="text-gray-500">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $tipo->orden }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('admin.tipos-documento.edit', $tipo->id) }}"
                                    class="text-blue-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.tipos-documento.destroy', $tipo->id) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este tipo?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No hay tipos definidos aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

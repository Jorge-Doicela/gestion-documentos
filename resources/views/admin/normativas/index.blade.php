@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Gestión de Normativas Documentales</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.normativas.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nueva Normativa</a>

        <table class="min-w-full mt-4 border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Tipo de Documento</th>
                    <th class="border px-4 py-2">Contenido</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($normativas as $normativa)
                    <tr>
                        <td class="border px-4 py-2">{{ $normativa->tipoDocumento->nombre }}</td>
                        <td class="border px-4 py-2">
                            {{ \Illuminate\Support\Str::limit(strip_tags($normativa->contenido), 100) }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('admin.normativas.edit', $normativa) }}"
                                class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('admin.normativas.destroy', $normativa) }}" method="POST" class="inline"
                                onsubmit="return confirm('¿Eliminar normativa?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $normativas->links() }}
        </div>
    </div>
@endsection

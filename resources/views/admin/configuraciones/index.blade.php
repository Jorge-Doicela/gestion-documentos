@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-6">
        <h1 class="text-2xl font-semibold mb-4">Configuraciones del Sistema</h1>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full table-auto border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left">Clave</th>
                    <th class="px-4 py-2">Valor</th>
                    <th class="px-4 py-2">Descripción</th>
                    <th class="px-4 py-2">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($configuraciones as $config)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $config->clave }}</td>
                        <td class="px-4 py-2">{{ $config->valor }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $config->descripcion }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.configuraciones.edit', $config) }}"
                                class="text-blue-600 hover:underline">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

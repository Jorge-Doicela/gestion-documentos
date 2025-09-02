@extends('layouts.app')

@section('title', 'Empresas')

@section('content')
    <div class="container mx-auto p-4">

        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Listado de Empresas</h1>
            <a href="{{ route('admin.empresas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Nueva Empresa
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario de filtros --}}
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="nombre" placeholder="Nombre" value="{{ request('nombre') }}"
                class="border rounded px-2 py-1">
            <input type="text" name="ruc" placeholder="RUC" value="{{ request('ruc') }}"
                class="border rounded px-2 py-1">
            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Filtrar</button>
        </form>

        <div class="flex justify-end gap-2 mb-4">
            <a href="{{ route('admin.empresas.export.excel') }}" class="bg-green-500 text-white px-4 py-2 rounded">Exportar
                Excel</a>
            <a href="{{ route('admin.empresas.export.pdf') }}" class="bg-red-500 text-white px-4 py-2 rounded">Exportar
                PDF</a>
        </div>


        {{-- Tabla de empresas --}}
        <table class="min-w-full bg-white border border-gray-200 rounded">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">Nombre</th>
                    <th class="py-2 px-4 border-b">RUC</th>
                    <th class="py-2 px-4 border-b">Teléfono</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Contacto</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empresas as $empresa)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $empresa->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $empresa->ruc }}</td>
                        <td class="py-2 px-4 border-b">{{ $empresa->telefono }}</td>
                        <td class="py-2 px-4 border-b">{{ $empresa->email }}</td>
                        <td class="py-2 px-4 border-b">{{ $empresa->contacto }}</td>
                        <td class="py-2 px-4 border-b flex gap-2">
                            <a href="{{ route('admin.empresas.edit', $empresa) }}"
                                class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</a>
                            <form action="{{ route('admin.empresas.destroy', $empresa) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar empresa?');">
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
            {{ $empresas->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

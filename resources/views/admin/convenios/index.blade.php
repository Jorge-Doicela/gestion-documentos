@extends('layouts.app')
@section('title', 'Convenios de Práctica')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Convenios de Práctica</h1>
            <a href="{{ route('admin.convenios.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Nuevo
                Convenio</a>
        </div>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Empresa</th>
                    <th class="border px-4 py-2">PDF</th>
                    <th class="border px-4 py-2">Fecha Inicio</th>
                    <th class="border px-4 py-2">Fecha Fin</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($convenios as $convenio)
                    <tr>
                        <td class="border px-4 py-2">{{ $convenio->empresa->nombre }}</td>
                        <td class="border px-4 py-2">
                            @if ($convenio->pdf_ruta)
                                <a href="{{ asset('storage/' . $convenio->pdf_ruta) }}" target="_blank"
                                    class="text-blue-600 underline">Ver PDF</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $convenio->fecha_inicio->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2">{{ $convenio->fecha_fin->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 flex gap-2">
                            <a href="{{ route('admin.convenios.edit', $convenio) }}"
                                class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</a>
                            <form action="{{ route('admin.convenios.destroy', $convenio) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar convenio?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

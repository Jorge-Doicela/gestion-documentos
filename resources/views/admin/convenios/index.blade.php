@extends('layouts.app')
@section('title', 'Convenios de Práctica')

@section('content')
    <div class="container mx-auto p-4 animate-fade-in font-sans text-gray-800">

        {{-- Encabezado principal y botón nuevo convenio --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">Convenios de Práctica</h1>
            <a href="{{ route('admin.convenios.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Nuevo Convenio
            </a>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="p-4 mb-4 rounded-lg bg-green-100 text-green-800 shadow-md animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botones de exportación --}}
        <div class="flex flex-wrap gap-2 justify-end mb-6">
            <a href="{{ route('admin.convenios.export.excel') }}"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md transition flex items-center gap-2">
                <i class="fas fa-file-excel"></i> Exportar Excel
            </a>
            <a href="{{ route('admin.convenios.export.pdf') }}"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </a>
        </div>

        {{-- Tabla de convenios --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-200 text-gray-600 text-sm">
                <thead class="bg-gray-100 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Empresa</th>
                        <th class="px-4 py-3 text-left">PDF</th>
                        <th class="px-4 py-3 text-left">Fecha Inicio</th>
                        <th class="px-4 py-3 text-left">Fecha Fin</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($convenios as $convenio)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $convenio->empresa->nombre }}</td>
                            <td class="px-4 py-2">
                                @if ($convenio->pdf_ruta)
                                    <a href="{{ asset('storage/' . $convenio->pdf_ruta) }}" target="_blank"
                                        class="text-blue-600 hover:underline">Ver PDF</a>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $convenio->fecha_inicio->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $convenio->fecha_fin->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 flex justify-center gap-2">
                                <a href="{{ route('admin.convenios.edit', $convenio) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg shadow-md transition flex items-center gap-1"
                                    title="Editar convenio">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('admin.convenios.destroy', $convenio) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar convenio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg shadow-md transition flex items-center gap-1"
                                        title="Eliminar convenio">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $convenios->links('pagination::tailwind') }}
        </div>

    </div>

    {{-- Animación fade-in global --}}
    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

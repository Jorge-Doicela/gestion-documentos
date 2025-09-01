@extends('layouts.app')

@section('title', 'Solicitudes de Plazas')

@section('content')
    <div class="container mx-auto p-4">

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-4">Solicitudes de Plazas</h1>

        @if ($solicitudes->isEmpty())
            <p>No hay solicitudes pendientes.</p>
        @else
            <table class="min-w-full bg-white border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border">Estudiante</th>
                        <th class="py-2 px-4 border">Correo</th>
                        <th class="py-2 px-4 border">Plaza</th>
                        <th class="py-2 px-4 border">Empresa</th>
                        <th class="py-2 px-4 border">Documentos</th>
                        <th class="py-2 px-4 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td class="py-2 px-4 border">{{ $solicitud->estudiante->name }}</td>
                            <td class="py-2 px-4 border">{{ $solicitud->estudiante->email }}</td>
                            <td class="py-2 px-4 border">{{ $solicitud->plaza->area_practica }}</td>
                            <td class="py-2 px-4 border">{{ $solicitud->plaza->empresa->nombre }}</td>
                            <td class="py-2 px-4 border">
                                @if ($solicitud->documentos)
                                    @foreach (json_decode($solicitud->documentos) as $doc)
                                        <a href="{{ asset('storage/' . $doc) }}" target="_blank"
                                            class="text-blue-600 underline">{{ basename($doc) }}</a><br>
                                    @endforeach
                                @else
                                    Sin documentos
                                @endif
                            </td>
                            <td class="py-2 px-4 border">
                                <form action="{{ route('solicitudes.asignar', $solicitud->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Asignar</button>
                                </form>

                                <form action="{{ route('solicitudes.rechazar', $solicitud->id) }}" method="POST"
                                    class="inline ml-2">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Rechazar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

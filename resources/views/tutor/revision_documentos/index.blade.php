@extends('layouts.app')

@section('title', 'Revisión de Documentos')

@section('content')
    {{-- Mensajes flash --}}
    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="bg-yellow-200 text-yellow-800 p-3 rounded mb-4">
            {{ session('warning') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-6">📑 Documentos Pendientes de Revisión</h1>

    @if ($documentos->isEmpty())
        <p class="text-gray-600">No hay documentos pendientes.</p>
    @else
        <div class="grid grid-cols-1 gap-4">
            @foreach ($documentos as $doc)
                <div class="p-4 bg-white rounded shadow">
                    <h3 class="font-semibold">{{ $doc->tipoDocumento->nombre }}</h3>
                    <p>Estudiante: {{ $doc->usuario->name }} ({{ $doc->usuario->email }})</p>
                    <p>Subido el: {{ $doc->created_at->format('d/m/Y H:i') }}</p>
                    <a href="{{ route('tutor.revision.show', $doc->id) }}"
                        class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Revisar Documento
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection

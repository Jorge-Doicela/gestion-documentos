{{-- resources/views/estudiante/documentos/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Subir Documento')

@section('content')
    <div class="max-w-2xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">📤 Subir Documento</h1>

        <a href="{{ route('estudiante.documentos.index') }}" class="text-blue-600 underline mb-4 inline-block">
            ⬅️ Volver a mis documentos
        </a>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-6">
            <p class="text-lg">Tipo de Documento:
                <span class="font-semibold text-blue-700">{{ $tipoDocumento->nombre }}</span>
            </p>
        </div>

        <form action="{{ route('estudiante.documentos.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            {{-- Campo oculto con el tipo de documento ya definido --}}
            <input type="hidden" name="tipo_documento_id" value="{{ $tipoDocumento->id }}">

            <div>
                <label for="archivo" class="block font-semibold text-gray-700">Archivo PDF</label>
                <input type="file" name="archivo" id="archivo" accept="application/pdf" required
                    class="mt-1 block w-full border-gray-300 shadow-sm rounded">
                <p class="text-sm text-gray-500 mt-1">
                    Tamaño máximo permitido: <strong>{{ number_format($tamanoMB, 2) }} MB</strong>
                </p>
                @error('archivo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                    Subir Documento
                </button>
            </div>
        </form>
    </div>
@endsection

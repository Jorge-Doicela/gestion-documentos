@extends('layouts.app')

@section('title', 'Re-subir Documento')

@section('content')
    <div class="max-w-lg mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Re-subir Documento: {{ $documento->tipoDocumento->nombre }}</h1>

        <form action="{{ route('estudiante.documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div>
                <label for="archivo" class="block mb-2 font-semibold text-gray-700">Archivo PDF</label>
                <input type="file" name="archivo" id="archivo" accept="application/pdf" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-500">
                @error('archivo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Solo archivos PDF. Tamaño máximo permitido: <strong>
                        {{ number_format($tamanoMB, 2) }} MB</strong></p>
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded transition">
                Actualizar Documento
            </button>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Re-subir Documento')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Re-subir Documento: {{ $documento->tipoDocumento->nombre }}</h1>

    <form action="{{ route('estudiante.documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data"
        class="max-w-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="archivo" class="block mb-1 font-semibold">Archivo PDF</label>
            <input type="file" name="archivo" id="archivo" accept="application/pdf" class="w-full" required>
            @error('archivo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Documento</button>
    </form>
@endsection

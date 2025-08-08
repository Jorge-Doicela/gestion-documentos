@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-2xl">
        <h1 class="text-2xl font-bold mb-4">Crear Nueva Normativa</h1>

        <form action="{{ route('admin.normativas.store') }}" method="POST" novalidate>
            @csrf

            <div class="mb-4">
                <label for="tipo_documento_id" class="block mb-2 font-semibold">Tipo de Documento</label>
                <select id="tipo_documento_id" name="tipo_documento_id"
                    class="w-full border rounded p-2 @error('tipo_documento_id') border-red-600 @enderror" required
                    aria-describedby="tipoDocumentoError">
                    <option value="">-- Seleccione --</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ old('tipo_documento_id') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_documento_id')
                    <p id="tipoDocumentoError" class="text-red-600 mt-1" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="contenido" class="block mb-2 font-semibold">Contenido</label>
                <textarea id="contenido" name="contenido" rows="6"
                    class="w-full border rounded p-2 @error('contenido') border-red-600 @enderror" aria-describedby="contenidoError">{{ old('contenido') }}</textarea>
                @error('contenido')
                    <div id="contenidoError"
                        class="mt-1 p-2 bg-red-100 border border-red-400 text-red-700 rounded text-sm flex items-center gap-2"
                        role="alert" aria-live="assertive" aria-atomic="true">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4m0 4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">
                    Guardar
                </button>
                <a href="{{ route('admin.normativas.index') }}"
                    class="text-gray-600 hover:underline focus:outline-none focus:ring focus:ring-gray-300">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor
                .create(document.querySelector('#contenido'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush

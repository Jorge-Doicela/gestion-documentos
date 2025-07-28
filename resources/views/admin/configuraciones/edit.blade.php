{{-- resources/views/admin/configuraciones/edit.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-6">
        <h1 class="text-2xl font-semibold mb-4">Editar Configuración</h1>

        <form method="POST" action="{{ route('admin.configuraciones.update', $configuracion) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Clave</label>
                <input type="text" value="{{ $configuracion->clave }}" disabled
                    class="w-full border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" />
            </div>

            <div class="mb-4">
                <label for="valor" class="block font-semibold mb-1">Valor</label>
                <input type="text" name="valor" id="valor" value="{{ old('valor', $configuracion->valor) }}"
                    required class="w-full border-gray-300 rounded px-3 py-2 @error('valor') border-red-500 @enderror" />
                @error('valor')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Descripción</label>
                <textarea disabled class="w-full border-gray-300 rounded px-3 py-2 bg-gray-100" rows="3">{{ $configuracion->descripcion }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Guardar
                </button>
                <a href="{{ route('admin.configuraciones.index') }}"
                    class="inline-block px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection

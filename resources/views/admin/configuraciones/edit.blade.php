@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-6">
        <h1 class="text-2xl font-semibold mb-4">Editar Configuración</h1>

        <form method="POST" action="{{ route('admin.configuraciones.update', $configuracion) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold">Clave</label>
                <input type="text" value="{{ $configuracion->clave }}" disabled class="w-full border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Valor</label>
                <input type="text" name="valor" value="{{ old('valor', $configuracion->valor) }}"
                    class="w-full border-gray-300 rounded" required>
                @error('valor')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Descripción</label>
                <textarea disabled class="w-full border-gray-300 rounded">{{ $configuracion->descripcion }}</textarea>
            </div>

            <div class="flex gap-2">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
                <a href="{{ route('admin.configuraciones.index') }}" class="text-gray-600 underline">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

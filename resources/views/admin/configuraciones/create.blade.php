@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-6">
        <h1 class="text-2xl font-semibold mb-4">Nueva Configuración</h1>

        <form method="POST" action="{{ route('admin.configuraciones.store') }}">
            @csrf

            <div class="mb-4">
                <label for="clave" class="block font-semibold mb-1">Clave</label>
                <input type="text" name="clave" id="clave" value="{{ old('clave') }}" required
                    class="w-full border-gray-300 rounded px-3 py-2 @error('clave') border-red-500 @enderror"
                    placeholder="Ejemplo: tamanio_maximo_archivo" autocomplete="off" />
                @error('clave')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Clave única para identificar la configuración (sin espacios).</p>
            </div>

            <div class="mb-4">
                <label for="valor" class="block font-semibold mb-1">Valor</label>
                <input type="text" name="valor" id="valor" value="{{ old('valor') }}" required
                    class="w-full border-gray-300 rounded px-3 py-2 @error('valor') border-red-500 @enderror"
                    placeholder="Ejemplo: 5242880" autocomplete="off" />
                @error('valor')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Valor asignado a la configuración.</p>
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block font-semibold mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full border-gray-300 rounded px-3 py-2 @error('descripcion') border-red-500 @enderror"
                    placeholder="Descripción breve sobre la configuración">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Crear
                </button>
                <a href="{{ route('admin.configuraciones.index') }}"
                    class="inline-block px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection

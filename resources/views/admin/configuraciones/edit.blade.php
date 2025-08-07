@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-6">
        <h1 class="text-2xl font-semibold mb-4">Editar Configuración</h1>

        <form method="POST" action="{{ route('admin.configuraciones.update', $configuracion) }}" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="clave" class="block font-semibold mb-1">Clave</label>
                <input type="text" id="clave" value="{{ $configuracion->clave }}" disabled
                    class="w-full border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" aria-disabled="true" />
            </div>

            <div class="mb-4">
                <label for="valor" class="block font-semibold mb-1">Valor</label>
                <input type="text" name="valor" id="valor" value="{{ old('valor', $configuracion->valor) }}"
                    required
                    class="w-full border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('valor') border-red-500 focus:ring-red-500 @enderror"
                    aria-describedby="valor-error" aria-invalid="@error('valor') true @else false @enderror" />
                @error('valor')
                    <p id="valor-error" role="alert" class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Modifique el valor según la configuración.</p>
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block font-semibold mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion') border-red-500 focus:ring-red-500 @enderror"
                    aria-describedby="descripcion-error" aria-invalid="@error('descripcion') true @else false @enderror">{{ old('descripcion', $configuracion->descripcion) }}</textarea>
                @error('descripcion')
                    <p id="descripcion-error" role="alert" class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    Guardar
                </button>
                <a href="{{ route('admin.configuraciones.index') }}"
                    class="inline-block px-4 py-2 border rounded text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection

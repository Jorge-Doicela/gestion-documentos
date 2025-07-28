@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-2xl">
        <h1 class="text-2xl font-bold mb-4">Crear Nueva Normativa</h1>

        <form action="{{ route('admin.normativas.store') }}" method="POST">
            @csrf

            <label class="block mb-2 font-semibold" for="tipo_documento_id">Tipo de Documento</label>
            <select id="tipo_documento_id" name="tipo_documento_id" class="w-full border rounded p-2 mb-4" required>
                <option value="">-- Seleccione --</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo_documento_id') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}</option>
                @endforeach
            </select>
            @error('tipo_documento_id')
                <p class="text-red-600">{{ $message }}</p>
            @enderror

            <label class="block mb-2 font-semibold" for="contenido">Contenido</label>
            <textarea id="contenido" name="contenido" rows="6" class="w-full border rounded p-2 mb-4" required>{{ old('contenido') }}</textarea>
            @error('contenido')
                <p class="text-red-600">{{ $message }}</p>
            @enderror

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
            <a href="{{ route('admin.normativas.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>
@endsection

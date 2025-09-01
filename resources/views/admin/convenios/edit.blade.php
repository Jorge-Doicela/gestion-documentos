@extends('layouts.app')
@section('title', 'Editar Convenio')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Editar Convenio</h1>

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.convenios.update', $convenio) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-4 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 font-bold">Empresa</label>
                <select name="empresa_id" class="w-full border p-2 rounded" required>
                    <option value="">Seleccionar empresa</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}"
                            {{ old('empresa_id', $convenio->empresa_id) == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">PDF del Convenio</label>
                @if ($convenio->pdf_ruta)
                    <a href="{{ asset('storage/' . $convenio->pdf_ruta) }}" target="_blank"
                        class="text-blue-600 underline mb-2 inline-block">Ver PDF actual</a>
                @endif
                <input type="file" name="pdf_ruta" accept="application/pdf" class="w-full border p-2 rounded">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" class="w-full border p-2 rounded"
                    value="{{ old('fecha_inicio', $convenio->fecha_inicio->format('Y-m-d')) }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Fecha de Fin</label>
                <input type="date" name="fecha_fin" class="w-full border p-2 rounded"
                    value="{{ old('fecha_fin', $convenio->fecha_fin->format('Y-m-d')) }}" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
            <a href="{{ route('admin.convenios.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
        </form>
    </div>
@endsection

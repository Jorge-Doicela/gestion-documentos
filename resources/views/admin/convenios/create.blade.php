@extends('layouts.app')
@section('title', 'Nuevo Convenio')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Registrar Nuevo Convenio</h1>

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.convenios.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-4 rounded shadow">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-bold">Empresa</label>
                <select name="empresa_id" class="w-full border p-2 rounded" required>
                    <option value="">Seleccionar empresa</option>
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">PDF del Convenio</label>
                <input type="file" name="pdf_ruta" accept="application/pdf" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" class="w-full border p-2 rounded"
                    value="{{ old('fecha_inicio') }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Fecha de Fin</label>
                <input type="date" name="fecha_fin" class="w-full border p-2 rounded" value="{{ old('fecha_fin') }}"
                    required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
            <a href="{{ route('admin.convenios.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
        </form>
    </div>
@endsection

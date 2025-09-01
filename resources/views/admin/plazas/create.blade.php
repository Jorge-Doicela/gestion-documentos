@extends('layouts.app')
@section('title', 'Nueva Plaza')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Registrar Nueva Plaza</h1>

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.plazas.store') }}" method="POST" class="bg-white p-4 rounded shadow">
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
                <label class="block mb-1 font-bold">Área de práctica</label>
                <input type="text" name="area" class="w-full border p-2 rounded" value="{{ old('area') }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Período académico</label>
                <input type="text" name="periodo" class="w-full border p-2 rounded" value="{{ old('periodo') }}"
                    placeholder="Ej: 2025-I" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Vacantes</label>
                <input type="number" name="vacantes" class="w-full border p-2 rounded" value="{{ old('vacantes', 1) }}"
                    min="1" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Requisitos</label>
                <textarea name="requisitos" class="w-full border p-2 rounded" rows="4">{{ old('requisitos') }}</textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
            <a href="{{ route('admin.plazas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
        </form>
    </div>
@endsection

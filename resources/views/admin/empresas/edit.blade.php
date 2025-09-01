@extends('layouts.app')
@section('title', 'Editar Empresa')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Editar Empresa</h1>

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.empresas.update', $empresa) }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 font-bold">Nombre</label>
                <input type="text" name="nombre" class="w-full border p-2 rounded"
                    value="{{ old('nombre', $empresa->nombre) }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">RUC</label>
                <input type="text" name="ruc" class="w-full border p-2 rounded"
                    value="{{ old('ruc', $empresa->ruc) }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Dirección</label>
                <input type="text" name="direccion" class="w-full border p-2 rounded"
                    value="{{ old('direccion', $empresa->direccion) }}">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Teléfono</label>
                <input type="text" name="telefono" class="w-full border p-2 rounded"
                    value="{{ old('telefono', $empresa->telefono) }}">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded"
                    value="{{ old('email', $empresa->email) }}">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-bold">Contacto</label>
                <input type="text" name="contacto" class="w-full border p-2 rounded"
                    value="{{ old('contacto', $empresa->contacto) }}">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
            <a href="{{ route('admin.empresas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
        </form>
    </div>
@endsection

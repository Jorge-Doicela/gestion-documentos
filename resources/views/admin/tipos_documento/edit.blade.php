@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Editar Tipo: {{ $tipo->nombre }}</h1>

        <form action="{{ route('admin.tipos-documento.update', $tipo->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            @include('admin.tipos_documento.form', ['tipo' => $tipo])
            <div class="mt-4">
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Actualizar</button>
                <a href="{{ route('admin.tipos-documento.index') }}" class="ml-3 text-gray-600 hover:underline">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

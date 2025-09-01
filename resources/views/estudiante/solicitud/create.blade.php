@extends('layouts.app')

@section('title', 'Postular a Plaza')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-2xl font-semibold mb-4">Postular a Plaza: {{ $plaza->area_practica }}</h2>
        <p class="mb-4"><strong>Empresa:</strong> {{ $plaza->empresa->nombre }}</p>
        <p class="mb-4"><strong>Período académico:</strong> {{ $plaza->periodo_academico }}</p>
        <p class="mb-4"><strong>Vacantes disponibles:</strong> {{ $plaza->vacantes }}</p>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('solicitud.store', $plaza->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="cv" class="block font-medium mb-2">CV (PDF)</label>
                <input type="file" name="cv" id="cv" accept=".pdf" class="border rounded p-2 w-full">
            </div>

            <div class="mb-4">
                <label for="documentos" class="block font-medium mb-2">Documentos adicionales (PDF/JPG/PNG)</label>
                <input type="file" name="documentos[]" id="documentos" multiple accept=".pdf,.jpg,.jpeg,.png"
                    class="border rounded p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Enviar Solicitud
            </button>
        </form>
    </div>
@endsection

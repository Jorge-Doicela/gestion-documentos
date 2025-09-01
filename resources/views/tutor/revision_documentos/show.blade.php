@extends('layouts.app')

@section('title', 'Revisar Documento')

@section('content')
    {{-- Mensajes flash --}}
    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="bg-yellow-200 text-yellow-800 p-3 rounded mb-4">
            {{ session('warning') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-6">🔍 Revisión del Documento</h1>

    {{-- Embed PDF usando ruta del controlador --}}
    <embed src="{{ route('tutor.revision.ver', $documento->id) }}" type="application/pdf" width="100%" height="600px" />

    {{-- Comentarios por sección --}}
    <h2 class="text-xl font-semibold mt-6 mb-2">🗂 Comentarios por sección</h2>

    <form method="POST" action="{{ route('tutor.revision.comentarios', $documento->id) }}">
        @csrf
        <div id="comentarios-container">
            <div class="mb-4 comentario-item">
                <label class="block mb-1 font-semibold">Sección:</label>
                <input type="text" name="comentarios[0][seccion]" class="w-full border p-2 rounded mb-2"
                    placeholder="Ej. Introducción">

                <label class="block mb-1 font-semibold">Comentario:</label>
                <textarea name="comentarios[0][mensaje]" class="w-full border p-2 rounded" rows="3"></textarea>
            </div>
        </div>

        <button type="button" onclick="agregarComentario()" class="mt-2 bg-gray-600 text-white px-3 py-1 rounded">
            + Añadir Sección
        </button>

        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            💾 Guardar Comentarios
        </button>
    </form>

    {{-- Comentarios guardados --}}
    @if ($documento->comentarios->isNotEmpty())
        <h3 class="text-lg font-bold mt-6 mb-2">💬 Comentarios guardados:</h3>
        <ul class="space-y-2">
            @foreach ($documento->comentarios as $comentario)
                <li class="border p-3 rounded bg-gray-50">
                    <strong>{{ $comentario->seccion }}:</strong> {{ $comentario->mensaje }}<br>
                    <span class="text-sm text-gray-500">
                        por {{ $comentario->usuario->name }} ({{ ucfirst($comentario->autor_rol) }}) -
                        {{ $comentario->created_at->format('d/m/Y H:i') }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Observaciones generales (rechazo) --}}
    <form method="POST" action="{{ route('tutor.revision.rechazar', $documento->id) }}" class="mt-6">
        @csrf
        <label class="block mb-2 font-semibold">Observaciones (en caso de rechazo):</label>
        <textarea name="comentarios" class="w-full border rounded p-2" rows="4"></textarea>

        <div class="mt-4 flex gap-4">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Rechazar Documento
            </button>
        </div>
    </form>

    {{-- Aprobación --}}
    <form method="POST" action="{{ route('tutor.revision.aprobar', $documento->id) }}" class="mt-4">
        @csrf
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Aprobar Documento
        </button>
    </form>
@endsection

@section('scripts')
    <script>
        let contador = 1;

        function agregarComentario() {
            const container = document.getElementById('comentarios-container');
            const nuevo = document.createElement('div');
            nuevo.classList.add('mb-4', 'comentario-item');
            nuevo.innerHTML = `
            <label class="block mb-1 font-semibold">Sección:</label>
            <input type="text" name="comentarios[${contador}][seccion]" class="w-full border p-2 rounded mb-2">

            <label class="block mb-1 font-semibold">Comentario:</label>
            <textarea name="comentarios[${contador}][mensaje]" class="w-full border p-2 rounded" rows="3"></textarea>
        `;
            container.appendChild(nuevo);
            contador++;
        }
    </script>
@endsection

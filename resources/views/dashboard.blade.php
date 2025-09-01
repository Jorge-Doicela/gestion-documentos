@extends('layouts.app')

@section('title', 'Panel Principal')

@section('content')
    <h1 class="text-3xl font-bold mb-8 text-center">Panel Principal</h1>

    {{-- Mensaje certificado para estudiantes --}}
    @role('Estudiante')
        @php
            $certificado = auth()->user()->certificado;
        @endphp

        @if ($certificado)
            <div class="max-w-md mx-auto mb-8 p-4 bg-green-100 border border-green-300 rounded text-center">
                <a href="{{ route('estudiante.certificados.descargar', $certificado->uuid) }}"
                    class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded shadow">
                    📥 Descargar Certificado Oficial
                </a>
            </div>
        @else
            <div class="max-w-md mx-auto mb-8 p-4 bg-yellow-100 border border-yellow-300 rounded text-center text-yellow-700">
                Su certificado aún no está disponible.
            </div>
        @endif
    @endrole

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Bloque Administrador General --}}
        @role('Administrador General')
            <a href="{{ route('admin.users.index') }}"
                class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center">
                👥 Gestión de Usuarios
            </a>

            <a href="{{ route('admin.configuraciones.index') }}"
                class="block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                ⚙️ Configuración Global del Sistema
            </a>

            <a href="{{ route('admin.logs.index') }}"
                class="block bg-red-600 hover:bg-red-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📝 Logs de Auditoría
            </a>

            <a href="{{ route('admin.empresas.index') }}"
                class="block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                🏢 Gestión de Empresas
            </a>

            <a href="{{ route('admin.plazas.index') }}"
                class="block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                💼 Gestión de Plazas
            </a>

            <a href="{{ route('admin.convenios.index') }}"
                class="block bg-teal-600 hover:bg-teal-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📑 Gestión de Convenios
            </a>

            <a href="{{ route('admin.tipos-documento.index') }}"
                class="block bg-green-600 hover:bg-green-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📄 Tipos de Documento
            </a>

            <a href="{{ route('admin.normativas.index') }}"
                class="block bg-teal-600 hover:bg-teal-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📚 Gestión de Normativas
            </a>
        @endrole

        {{-- Bloque Coordinador de Prácticas (con los mismos botones que el Administrador) --}}
        @role('Coordinador de Prácticas')
            <a href="{{ route('admin.users.index') }}"
                class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center">
                👥 Gestión de Usuarios
            </a>

            <a href="{{ route('admin.configuraciones.index') }}"
                class="block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                ⚙️ Configuración Global del Sistema
            </a>

            <a href="{{ route('admin.logs.index') }}"
                class="block bg-red-600 hover:bg-red-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📝 Logs de Auditoría
            </a>

            <a href="{{ route('admin.empresas.index') }}"
                class="block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                🏢 Gestión de Empresas
            </a>

            <a href="{{ route('admin.plazas.index') }}"
                class="block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                💼 Gestión de Plazas
            </a>

            <a href="{{ route('admin.convenios.index') }}"
                class="block bg-teal-600 hover:bg-teal-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📑 Gestión de Convenios
            </a>

            <a href="{{ route('admin.tipos-documento.index') }}"
                class="block bg-green-600 hover:bg-green-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📄 Tipos de Documento
            </a>

            <a href="{{ route('admin.normativas.index') }}"
                class="block bg-teal-600 hover:bg-teal-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📚 Gestión de Normativas
            </a>
        @endrole

        {{-- Bloque Tutor Académico --}}
        @role('Tutor Académico')
            <a href="{{ route('tutor.dashboard') }}"
                class="block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center">
                🧑‍🏫 Panel Tutor Académico
            </a>

            <a href="{{ route('tutor.revision.index') }}"
                class="block bg-orange-600 hover:bg-orange-700 text-white font-semibold py-4 px-6 rounded-xl shadow text-center mt-4">
                📝 Revisión de Documentos
            </a>

            <a href="{{ route('tutor.historial.index') }}"
                class="block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-4 px-6 rounded-xl shadow text-center mt-4">
                📜 Historial de Revisión
            </a>

            <a href="{{ route('normativas.index') }}"
                class="block bg-teal-600 hover:bg-teal-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📚 Ver Normativas
            </a>
        @endrole

        {{-- Bloque Estudiante --}}
        @role('Estudiante')
            <a href="{{ route('estudiante.dashboard') }}"
                class="block bg-pink-600 hover:bg-pink-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center">
                🎓 Panel Estudiante
            </a>

            <a href="{{ route('estudiante.documentos.index') }}"
                class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📄 Mis Documentos y Estados
            </a>

            <a href="{{ route('estudiante.solicitud.create', ['plaza' => 0]) }}"
                class="block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                💼 Postular a Plazas
            </a>

            <a href="{{ route('normativas.index') }}"
                class="block bg-teal-600 hover:bg-teal-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📚 Ver Normativas
            </a>
        @endrole

    </div>
@endsection

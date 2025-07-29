@extends('layouts.app')

@section('title', 'Panel Principal')

@section('content')
    <h1 class="text-3xl font-bold mb-8 text-center">Panel Principal</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @role('Administrador General')
            <a href="{{ route('admin.users.index') }}"
                class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center">
                👥 Gestión de Usuarios
            </a>

            <a href="{{ route('admin.tipos-documento.index') }}"
                class="block bg-green-600 hover:bg-green-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center">
                📄 Tipos de Documento
            </a>

            <a href="{{ route('admin.configuraciones.index') }}"
                class="block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center">
                ⚙️ Configuración Global del Sistema
            </a>

            <a href="{{ route('admin.normativas.index') }}"
                class="block bg-teal-600 hover:bg-teal-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📚 Gestión de Normativas
            </a>

            <a href="{{ route('admin.logs.index') }}"
                class="block bg-red-600 hover:bg-red-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📝 Logs de Auditoría
            </a>
        @endrole

        @role('Coordinador de Prácticas')
            <a href="{{ route('coordinador.dashboard') }}"
                class="block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center">
                📋 Panel Coordinador
            </a>
        @endrole

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
        @endrole

        @role('Estudiante')
            <a href="{{ route('estudiante.dashboard') }}"
                class="block bg-pink-600 hover:bg-pink-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center">
                🎓 Panel Estudiante
            </a>

            <a href="{{ route('normativas.index') }}"
                class="block bg-teal-600 hover:bg-teal-700 text-white font-semibold py-6 px-6 rounded-xl shadow text-center mt-4">
                📚 Ver Normativas
            </a>
        @endrole

    </div>

    {{-- Botón rápido para ir al Dashboard Tutor, solo visible para Administrador General --}}
    @role('Administrador General')
        <div class="mt-10 text-center">
            <a href="{{ route('tutor.dashboard') }}"
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded shadow">
                🧑‍🏫 Ir al Dashboard Tutor Académico
            </a>
        </div>
    @endrole

@endsection

@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario de Filtros --}}
        <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-2 items-center"
                id="filter-form">
                <input type="text" name="search" placeholder="Buscar nombre o email" value="{{ request('search') }}"
                    class="border rounded px-3 py-1" />

                <select name="role" id="role-filter" class="border rounded px-3 py-1">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(request('role') == $role)>{{ $role }}</option>
                    @endforeach
                </select>

                <div id="carrera-filter-container" class="hidden">
                    <select name="carrera_id" class="border rounded px-3 py-1">
                        <option value="">Todas las carreras</option>
                        @foreach ($carreras as $id => $nombre)
                            <option value="{{ $id }}" @selected(request('carrera_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="tutor-filter-container" class="hidden">
                    <select name="tutor_id" class="border rounded px-3 py-1">
                        <option value="">Todos los tutores</option>
                        @foreach ($tutores as $id => $nombre)
                            <option value="{{ $id }}" @selected(request('tutor_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">Filtrar</button>
                <a href="{{ route('admin.users.index') }}"
                    class="ml-2 px-4 py-1 bg-gray-300 rounded hover:bg-gray-400">Limpiar</a>
            </form>


        </div>

        {{-- Botón de Nuevo Usuario --}}
        <div class="mb-4">
            <a href="{{ route('admin.users.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Nuevo Usuario</a>
        </div>

        {{-- Tabla de usuarios --}}
        <table class="min-w-full bg-white rounded shadow overflow-hidden">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Nombre</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Rol</th>
                    <th class="py-3 px-6 text-left">Teléfono</th>
                    <th class="py-3 px-6 text-left">Carrera</th>
                    <th class="py-3 px-6 text-left">Tutor</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @foreach ($users as $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $user->email }}</td>
                        <td class="py-3 px-6 text-left">{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td class="py-3 px-6 text-left">{{ $user->telefono ?? '-' }}</td>
                        <td class="py-3 px-6 text-left">{{ $user->carrera->nombre ?? '-' }}</td>
                        <td class="py-3 px-6 text-left">{{ $user->tutor->name ?? '-' }}</td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('admin.users.show', $user) }}"
                                class="text-green-600 hover:text-green-900 mr-2">Ver</a>
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="text-blue-600 hover:text-blue-900 mr-2">Editar</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('¿Eliminar usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role-filter');
            const carreraContainer = document.getElementById('carrera-filter-container');
            const tutorContainer = document.getElementById('tutor-filter-container');

            function toggleFilterFields() {
                const selectedRole = roleSelect.value;

                // Roles con carrera
                const rolesConCarrera = [
                    'Coordinador de Prácticas',
                    'Tutor Académico',
                    'Estudiante'
                ];

                // Roles con tutor
                const rolesConTutor = [
                    'Estudiante'
                ];

                if (rolesConCarrera.includes(selectedRole)) {
                    carreraContainer.classList.remove('hidden');
                } else {
                    carreraContainer.classList.add('hidden');
                }

                if (rolesConTutor.includes(selectedRole)) {
                    tutorContainer.classList.remove('hidden');
                } else {
                    tutorContainer.classList.add('hidden');
                }
            }

            roleSelect.addEventListener('change', toggleFilterFields);

            // Ejecutar al cargar para respetar valor actual
            toggleFilterFields();
        });
    </script>
@endpush

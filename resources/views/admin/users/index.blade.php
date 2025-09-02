@extends('layouts.app')

@section('header')
    <h2 class="font-bold text-3xl text-gray-900 leading-tight">Gestión de Usuarios</h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 space-y-6">

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded shadow-md animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
        <div
            class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-fade-in">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-2 items-center flex-1"
                id="filter-form">
                <input type="text" name="search" placeholder="Buscar nombre o email" value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full md:w-64 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />

                <select name="role" id="role-filter"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full md:w-48 focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(request('role') == $role)>{{ $role }}</option>
                    @endforeach
                </select>

                <div id="carrera-filter-container" class="hidden">
                    <select name="carrera_id"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full md:w-48 focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">Todas las carreras</option>
                        @foreach ($carreras as $id => $nombre)
                            <option value="{{ $id }}" @selected(request('carrera_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="tutor-filter-container" class="hidden">
                    <select name="tutor_id"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full md:w-48 focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">Todos los tutores</option>
                        @foreach ($tutores as $id => $nombre)
                            <option value="{{ $id }}" @selected(request('tutor_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">Filtrar</button>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition duration-200 shadow-md">Limpiar</a>
                </div>
            </form>
        </div>

        {{-- Exportar y Nuevo Usuario --}}
        <div class="flex flex-wrap gap-2 justify-between items-center">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.users.export.excel', request()->query()) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-md">Exportar
                    Excel</a>
                <a href="{{ route('admin.users.export.pdf', request()->query()) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md">Exportar
                    PDF</a>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">Nuevo Usuario</a>
        </div>

        {{-- Tabla escritorio --}}
        <div class="hidden md:block overflow-x-auto bg-white rounded-lg shadow-md animate-fade-in">
            <table class="min-w-full text-left text-gray-600 text-sm divide-y divide-gray-200">
                <thead class="bg-gray-100 uppercase text-gray-700 text-xs tracking-wider">
                    <tr>
                        <th class="py-3 px-6">Nombre</th>
                        <th class="py-3 px-6">Email</th>
                        <th class="py-3 px-6">Rol</th>
                        <th class="py-3 px-6">Teléfono</th>
                        <th class="py-3 px-6">Carrera</th>
                        <th class="py-3 px-6">Tutor</th>
                        <th class="py-3 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-6">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6">{{ $user->roles->pluck('name')->join(', ') }}</td>
                            <td class="py-3 px-6">{{ $user->telefono ?? '-' }}</td>
                            <td class="py-3 px-6">{{ $user->carrera->nombre ?? '-' }}</td>
                            <td class="py-3 px-6">{{ $user->tutor->name ?? '-' }}</td>
                            <td class="py-3 px-6 text-center space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="text-green-600 hover:text-green-900 transition font-semibold">Ver</a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="text-blue-600 hover:text-blue-900 transition font-semibold">Editar</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('¿Eliminar usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 transition font-semibold">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tarjetas móvil --}}
        <div class="md:hidden grid gap-4">
            @foreach ($users as $user)
                <div class="bg-white rounded-lg shadow-md p-4 space-y-2 animate-fade-in">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800 text-lg">{{ $user->name }}</h3>
                        <span class="text-sm text-gray-500">{{ $user->roles->pluck('name')->join(', ') }}</span>
                    </div>
                    <p class="text-sm text-gray-600"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="text-sm text-gray-600"><strong>Teléfono:</strong> {{ $user->telefono ?? '-' }}</p>
                    <p class="text-sm text-gray-600"><strong>Carrera:</strong> {{ $user->carrera->nombre ?? '-' }}</p>
                    <p class="text-sm text-gray-600"><strong>Tutor:</strong> {{ $user->tutor->name ?? '-' }}</p>
                    <div class="flex gap-2 mt-2 flex-wrap">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-xs font-semibold">Ver</a>
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-xs font-semibold">Editar</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('¿Eliminar usuario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs font-semibold">Eliminar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

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
                const rolesConCarrera = ['Coordinador de Prácticas', 'Tutor Académico', 'Estudiante'];
                const rolesConTutor = ['Estudiante'];

                carreraContainer.classList.toggle('hidden', !rolesConCarrera.includes(selectedRole));
                tutorContainer.classList.toggle('hidden', !rolesConTutor.includes(selectedRole));
            }

            roleSelect.addEventListener('change', toggleFilterFields);
            toggleFilterFields();
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Animaciones suaves */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

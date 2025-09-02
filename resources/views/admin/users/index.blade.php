@extends('layouts.app')

@section('header')
    <h2 class="font-display font-bold text-4xl text-institutional-dark leading-tight animate-fade-in-up">
        Gestión de Usuarios
    </h2>
@endsection

@section('content')
    <div class="container-custom py-6 space-y-8 animate-fade-in">

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="p-4 bg-success text-white rounded-lg shadow-md animate-slide-up-fade">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Filtros y Acciones --}}
        <div
            class="bg-white p-6 rounded-2xl shadow-soft-lg flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-fade-in-down">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-3 items-center flex-1">
                <input type="text" name="search" placeholder="Buscar nombre o email" value="{{ request('search') }}"
                    class="border-gray-300 rounded-lg shadow-sm px-4 py-2 w-full md:w-64 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />

                <select name="role" id="role-filter"
                    class="border-gray-300 rounded-lg shadow-sm px-4 py-2 w-full md:w-48 focus:ring-gold-dark focus:border-gold-dark transition duration-400">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(request('role') == $role)>{{ $role }}</option>
                    @endforeach
                </select>

                <div id="carrera-filter-container" class="hidden w-full md:w-48 transition duration-400">
                    <select name="carrera_id"
                        class="border-gray-300 rounded-lg shadow-sm px-4 py-2 w-full focus:ring-gold-dark focus:border-gold-dark transition duration-400">
                        <option value="">Todas las carreras</option>
                        @foreach ($carreras as $id => $nombre)
                            <option value="{{ $id }}" @selected(request('carrera_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="tutor-filter-container" class="hidden w-full md:w-48 transition duration-400">
                    <select name="tutor_id"
                        class="border-gray-300 rounded-lg shadow-sm px-4 py-2 w-full focus:ring-gold-dark focus:border-gold-dark transition duration-400">
                        <option value="">Todos los tutores</option>
                        @foreach ($tutores as $id => $nombre)
                            <option value="{{ $id }}" @selected(request('tutor_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2 mt-2 md:mt-0">
                    <button type="submit" class="btn-primary flex items-center gap-2">
                        <i class="fas fa-filter"></i>
                        Filtrar
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition shadow-md flex items-center gap-2 font-bold">
                        <i class="fas fa-times"></i>
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- Botones de acción --}}
        <div class="flex flex-wrap gap-4 justify-end items-center animate-slide-in-right">
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('admin.users.export.excel', request()->query()) }}"
                    class="btn-secondary bg-eco text-white hover:bg-green-700 hover:text-white transition duration-200">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="{{ route('admin.users.export.pdf', request()->query()) }}"
                    class="btn-secondary bg-danger text-white hover:bg-red-700 hover:text-white transition duration-200">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn-primary animate-pulse-accent">
                <i class="fas fa-user-plus"></i> Nuevo Usuario
            </a>
        </div>

        {{-- Tabla de usuarios (escritorio) --}}
        <div class="hidden md:block overflow-x-auto bg-white rounded-4xl shadow-soft-lg animate-fade-in">
            <table class="min-w-full text-left text-gray-600 divide-y divide-gray-200">
                <thead
                    class="bg-institutional-light uppercase text-institutional-dark text-xs tracking-wider font-semibold">
                    <tr>
                        <th class="py-4 px-6">Nombre</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Rol</th>
                        <th class="py-4 px-6">Teléfono</th>
                        <th class="py-4 px-6">Carrera</th>
                        <th class="py-4 px-6">Tutor</th>
                        <th class="py-4 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="py-3 px-6">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6">
                                <span
                                    class="bg-institutional-light text-institutional-dark px-2 py-1 rounded-full text-xxs font-semibold">
                                    {{ $user->roles->pluck('name')->join(', ') }}
                                </span>
                            </td>
                            <td class="py-3 px-6">{{ $user->telefono ?? '-' }}</td>
                            <td class="py-3 px-6">{{ $user->carrera->nombre ?? '-' }}</td>
                            <td class="py-3 px-6">{{ $user->tutor->name ?? '-' }}</td>
                            <td class="py-3 px-6 text-center space-x-3">
                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="text-info hover:text-blue-700 transition" title="Ver detalles">
                                    <i class="fas fa-eye text-xl"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="text-warning hover:text-yellow-700 transition" title="Editar usuario">
                                    <i class="fas fa-edit text-xl"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario? Esta acción es irreversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:text-red-700 transition"
                                        title="Eliminar usuario">
                                        <i class="fas fa-trash text-xl"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tarjetas de usuarios (móvil) --}}
        <div class="md:hidden grid gap-4 animate-fade-in-up">
            @foreach ($users as $user)
                <div class="bg-white rounded-2xl shadow-soft-lg p-5 space-y-3 card-hover transition duration-400">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-lg font-display text-institutional-dark">{{ $user->name }}</h3>
                        <span
                            class="text-sm text-institutional-dark bg-steel-light px-2 py-1 rounded-full font-semibold">{{ $user->roles->pluck('name')->join(', ') }}</span>
                    </div>
                    <div class="space-y-1 text-sm text-gray-700">
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Teléfono:</strong> {{ $user->telefono ?? '-' }}</p>
                        <p><strong>Carrera:</strong> {{ $user->carrera->nombre ?? '-' }}</p>
                        <p><strong>Tutor:</strong> {{ $user->tutor->name ?? '-' }}</p>
                    </div>
                    <div class="flex gap-2 mt-4 flex-wrap">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="px-3 py-1 bg-info text-white rounded-lg hover:bg-blue-700 transition text-xs font-semibold flex items-center gap-1 shadow-md">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="px-3 py-1 bg-warning text-white rounded-lg hover:bg-yellow-700 transition text-xs font-semibold flex items-center gap-1 shadow-md">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario? Esta acción es irreversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 bg-danger text-white rounded-lg hover:bg-red-700 transition text-xs font-semibold flex items-center gap-1 shadow-md">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-8 animate-fade-in">
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

                // Transiciones suaves
                carreraContainer.classList.remove('hidden');
                tutorContainer.classList.remove('hidden');

                if (!rolesConCarrera.includes(selectedRole)) {
                    carreraContainer.classList.add('hidden');
                }
                if (!rolesConTutor.includes(selectedRole)) {
                    tutorContainer.classList.add('hidden');
                }
            }

            roleSelect.addEventListener('change', toggleFilterFields);
            toggleFilterFields();
        });
    </script>
@endpush

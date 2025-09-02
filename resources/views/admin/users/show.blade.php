@extends('layouts.app')

@section('header')
    <h2 class="font-display font-bold text-4xl text-institutional-dark leading-tight animate-fade-in-up">
        📋 Detalle del Usuario
    </h2>
@endsection

@section('content')
    <div class="container-custom py-8 animate-fade-in">
        <div class="bg-white shadow-soft-lg rounded-2xl overflow-hidden">
            {{-- Encabezado --}}
            <div
                class="px-8 py-6 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                <h3 class="text-3xl font-bold font-display text-institutional-dark">{{ $user->name }}</h3>
                <span class="px-3 py-1 bg-institutional-light text-institutional-dark text-sm rounded-full font-semibold">
                    {{ $user->roles->pluck('name')->join(', ') ?: 'Sin rol asignado' }}
                </span>
            </div>

            {{-- Información del usuario --}}
            <div class="px-8 py-8 space-y-6 text-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="font-bold text-institutional mb-1">📧 Email</p>
                        <p class="text-steel">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="font-bold text-institutional mb-1">📱 Teléfono</p>
                        <p class="text-steel">{{ $user->telefono ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-bold text-institutional mb-1">🏠 Dirección</p>
                        <p class="text-steel">{{ $user->direccion ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-bold text-institutional mb-1">🆔 Identificación</p>
                        <p class="text-steel">{{ $user->identificacion ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-bold text-institutional mb-1">🎂 Fecha de Nacimiento</p>
                        <p class="text-steel">
                            {{ $user->fecha_nacimiento ? $user->fecha_nacimiento->format('d/m/Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="font-bold text-institutional mb-1">⚧ Género</p>
                        <p class="text-steel">{{ $user->genero ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-bold text-institutional mb-1">🎓 Carrera</p>
                        <p class="text-steel">{{ $user->carrera->nombre ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-bold text-institutional mb-1">👨‍🏫 Tutor</p>
                        <p class="text-steel">{{ $user->tutor->name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Fechas --}}
            <div
                class="px-8 py-6 bg-gray-50 border-t border-gray-200 text-sm text-gray-600 grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><span class="font-semibold text-institutional-dark">📅 Creado:</span>
                    {{ $user->created_at->format('d/m/Y H:i') }}</p>
                <p><span class="font-semibold text-institutional-dark">✏️ Actualizado:</span>
                    {{ $user->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            {{-- Acciones --}}
            <div class="px-8 py-6 border-t border-gray-200 flex flex-wrap gap-4 justify-between items-center">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a Usuarios
                </a>

                <div class="flex gap-4">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-primary-info" title="Editar usuario">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                        onsubmit="return confirm('¿Seguro que deseas eliminar este usuario? Esta acción es irreversible.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-primary-danger" title="Eliminar usuario">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

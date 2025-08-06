@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalle del Usuario</h2>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8 bg-white shadow rounded">
        <div class="px-6 py-4">
            <h3 class="text-lg font-semibold mb-4">{{ $user->name }}</h3>

            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Roles:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>

            <p><strong>Teléfono:</strong> {{ $user->telefono ?? '-' }}</p>
            <p><strong>Dirección:</strong> {{ $user->direccion ?? '-' }}</p>
            <p><strong>Identificación:</strong> {{ $user->identificacion ?? '-' }}</p>
            <p><strong>Fecha de Nacimiento:</strong>
                {{ $user->fecha_nacimiento ? $user->fecha_nacimiento->format('d/m/Y') : '-' }}</p>
            <p><strong>Género:</strong> {{ $user->genero ?? '-' }}</p>
            <p><strong>Carrera:</strong> {{ $user->carrera->nombre ?? '-' }}</p>
            <p><strong>Tutor Asignado:</strong> {{ $user->tutor->name ?? '-' }}</p>

            <p><strong>Fecha de creación:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Última actualización:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            <a href="{{ route('admin.users.index') }}"
                class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Volver a Usuarios</a>
        </div>
    </div>
@endsection

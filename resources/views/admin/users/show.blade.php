@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalle Usuario</h2>
@endsection

@section('content')
    <div class="max-w-lg mx-auto py-6 sm:px-6 lg:px-8 bg-white shadow rounded p-6">
        <p><strong>Nombre:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Roles:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>
        <p><strong>Fecha creación:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Última actualización:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>

        <a href="{{ route('admin.users.index') }}"
            class="mt-4 inline-block px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Volver</a>
    </div>
@endsection

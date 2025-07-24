@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-semibold mb-4">Mi Perfil</h1>

        <div class="mb-2">
            <strong>Nombre:</strong> {{ $user->name }}
        </div>

        <div class="mb-2">
            <strong>Email:</strong> {{ $user->email }}
        </div>

        {{-- Puedes agregar más campos aquí --}}

        <a href="{{ route('profile.edit') }}"
            class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Editar Perfil
        </a>
    </div>
@endsection

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

        <div class="mb-4">
            <a href="{{ route('admin.users.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Nuevo Usuario</a>
        </div>

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

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection

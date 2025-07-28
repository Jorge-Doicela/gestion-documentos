@extends('layouts.app')

@section('title', 'Logs de Actividad')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Logs de Actividad</h1>

        <form method="GET" action="{{ route('admin.logs_actividad.index') }}"
            class="mb-6 grid grid-cols-1 sm:grid-cols-4 gap-4">
            <input type="text" name="accion" value="{{ request('accion') }}" placeholder="Buscar acción"
                class="border rounded px-3 py-2" />

            <select name="user_id" class="border rounded px-3 py-2">
                <option value="">-- Usuario --</option>
                @foreach (\App\Models\User::orderBy('name')->get() as $user)
                    <option value="{{ $user->id }}" @if (request('user_id') == $user->id) selected @endif>
                        {{ $user->name }}</option>
                @endforeach
            </select>

            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                class="border rounded px-3 py-2" />
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                class="border rounded px-3 py-2" />

            <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">Filtrar</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 border-b">ID</th>
                        <th class="px-4 py-2 border-b">Usuario</th>
                        <th class="px-4 py-2 border-b">Acción</th>
                        <th class="px-4 py-2 border-b">Descripción</th>
                        <th class="px-4 py-2 border-b">IP</th>
                        <th class="px-4 py-2 border-b">Agente</th>
                        <th class="px-4 py-2 border-b">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $log->id }}</td>
                            <td class="px-4 py-2 border-b">{{ $log->user ? $log->user->name : 'N/A' }}</td>
                            <td class="px-4 py-2 border-b">{{ $log->accion }}</td>
                            <td class="px-4 py-2 border-b">{{ $log->descripcion }}</td>
                            <td class="px-4 py-2 border-b">{{ $log->ip ?? '-' }}</td>
                            <td class="px-4 py-2 border-b break-words max-w-xs">{{ $log->user_agent ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $log->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center">No hay registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Logs de Auditoría')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Logs de Auditoría</h1>

    <form method="GET" action="{{ route('admin.logs.index') }}" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Todos</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" @selected(request('user_id') == $usuario->id)>{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="accion" class="block text-sm font-medium text-gray-700">Acción</label>
            <input type="text" name="accion" id="accion" value="{{ request('accion') }}"
                placeholder="Buscar acción..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
        </div>

        <div>
            <label for="fecha_desde" class="block text-sm font-medium text-gray-700">Fecha Desde</label>
            <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
        </div>

        <div>
            <label for="fecha_hasta" class="block text-sm font-medium text-gray-700">Fecha Hasta</label>
            <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
        </div>

        <div>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700
                text-white font-semibold rounded-md shadow">Filtrar</button>
        </div>
    </form>

    <div class="overflow-x-auto rounded-lg border border-gray-300">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Agent
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($logs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->user?->name ?? 'Sistema' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->accion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->descripcion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->ip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 break-words max-w-xs">
                            {{ $log->user_agent }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay registros de logs.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
@endsection

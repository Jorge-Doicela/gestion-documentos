@extends('layouts.app')

@section('title', 'Logs de Auditoría')

@section('content')
    <div class="container-custom py-6 lg:px-8 animate-fade-in-up">

        <div class="flex flex-wrap justify-between items-center mb-6 gap-3">
            <h1 class="text-3xl font-display font-bold text-institutional-dark text-gradient-istpet">
                📝 Logs de Auditoría
            </h1>
            <p class="text-institutional text-sm font-sans">
                Visualiza todas las acciones realizadas por los usuarios en el sistema.
            </p>
        </div>

        <form method="GET" action="{{ route('admin.logs.index') }}"
            class="mb-6 flex flex-wrap gap-4 items-end glass-dark p-6 rounded-lg animate-fade-in-down" role="search"
            aria-label="Filtrar logs">

            <div>
                <label for="user_id" class="block text-sm font-semibold text-white">Usuario</label>
                <select name="user_id" id="user_id"
                    class="mt-1 block w-full md:w-48 border border-steel-light rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800">
                    <option value="">Todos</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" @selected(request('user_id') == $usuario->id)>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="accion" class="block text-sm font-semibold text-white">Acción</label>
                <input type="text" name="accion" id="accion" value="{{ request('accion') }}"
                    placeholder="Buscar acción..."
                    class="mt-1 block w-full md:w-48 border border-steel-light rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800" />
            </div>

            <div>
                <label for="fecha_desde" class="block text-sm font-semibold text-white">Fecha Desde</label>
                <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}"
                    class="mt-1 block w-full md:w-48 border border-steel-light rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800" />
            </div>

            <div>
                <label for="fecha_hasta" class="block text-sm font-semibold text-white">Fecha Hasta</label>
                <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
                    class="mt-1 block w-full md:w-48 border border-steel-light rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800" />
            </div>

            <div>
                <button type="submit" class="btn-primary inline-flex items-center gap-2">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </div>
        </form>

        <div class="overflow-x-auto rounded-lg border border-steel-light shadow-soft-lg md:block hidden animate-scale-in">
            <table class="min-w-full divide-y divide-steel-light text-sm text-gray-700">
                <thead class="bg-institutional-light text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Acción</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">IP</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">User Agent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-100 transition duration-400">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->user?->name ?? 'Sistema' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->accion }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->descripcion }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->ip }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 break-words max-w-xs">
                                {{ $log->user_agent }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                ⚠️ No hay registros de logs.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="md:hidden space-y-4 animate-fade-in">
            @forelse ($logs as $log)
                <div class="bg-white rounded-lg shadow-soft-lg p-4 card-hover border border-gray-200">
                    <p class="text-sm font-semibold text-institutional-dark">
                        <i class="fas fa-calendar-alt text-institutional"></i>
                        <span class="ml-2">Fecha:</span> {{ $log->created_at->format('Y-m-d H:i:s') }}
                    </p>
                    <p class="text-sm text-gray-700 mt-2">
                        <strong>Usuario:</strong> {{ $log->user?->name ?? 'Sistema' }}
                    </p>
                    <p class="text-sm text-gray-700">
                        <strong>Acción:</strong> {{ $log->accion }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>Descripción:</strong> {{ $log->descripcion }}
                    </p>
                    <p class="text-sm text-gray-700">
                        <strong>IP:</strong> {{ $log->ip }}
                    </p>
                    <p class="text-sm text-gray-700 break-words">
                        <strong>User Agent:</strong> {{ $log->user_agent }}
                    </p>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-soft-lg p-6 text-center text-gray-500 animate-fade-in-up">
                    ⚠️ No hay registros de logs.
                </div>
            @endforelse
        </div>

        <div class="mt-6 animate-fade-in-up">
            {{ $logs->links() }}
        </div>

    </div>
@endsection

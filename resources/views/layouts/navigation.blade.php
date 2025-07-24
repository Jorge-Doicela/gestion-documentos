<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">
                    {{ config('app.name', 'Gestion Documentos') }}
                </a>
            </div>

            {{-- Navegación principal --}}
            <div class="hidden md:flex space-x-6">
                @role('admin')
                    <a href="{{ route('admin.users.index') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Usuarios</a>
                    <a href="{{ route('admin.configuraciones.index') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Configuraciones</a>
                    <a href="{{ route('admin.normativas.index') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Normativas</a>
                    <a href="{{ route('admin.logs.index') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Auditoría</a>
                @endrole

                @role('tutor')
                    <a href="{{ route('tutor.estudiantes.index') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Mis Estudiantes</a>
                    <a href="{{ route('tutor.documentos.revision') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Revisión Documentos</a>
                @endrole

                @role('coordinador')
                    <a href="{{ route('coordinador.documentos.aprobados') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Documentos Aprobados</a>
                    <a href="{{ route('coordinador.certificados.index') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Certificados</a>
                @endrole

                @role('estudiante')
                    <a href="{{ route('estudiante.documentos.index') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Mis Documentos</a>
                    <a href="{{ route('estudiante.certificados.index') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Mis Certificados</a>
                    <a href="{{ route('estudiante.normativas.index') }}"
                        class="text-gray-700 hover:text-indigo-600 font-semibold">Normativas</a>
                @endrole
            </div>

            {{-- Dropdown usuario y logout --}}
            <div class="ml-4 relative">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Perfil</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">
                                Cerrar sesión
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>

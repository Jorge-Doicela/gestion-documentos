<nav class="bg-institutional-light shadow-md glass-dark">
    <div class="container-custom px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-display font-bold text-institutional">
                    ISTPET
                </a>
            </div>

            {{-- Navegación principal --}}
            <div class="hidden md:flex space-x-6">
                @role('admin')
                    <a href="{{ route('admin.users.index') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Usuarios</a>
                    <a href="{{ route('admin.configuraciones.index') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Configuraciones</a>
                    <a href="{{ route('admin.normativas.index') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Normativas</a>
                    <a href="{{ route('admin.logs.index') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Auditoría</a>
                @endrole

                @role('tutor')
                    <a href="{{ route('tutor.estudiantes.index') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Mis
                        Estudiantes</a>
                    <a href="{{ route('tutor.documentos.revision') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Revisión
                        Documentos</a>
                @endrole

                @role('coordinador')
                    <a href="{{ route('coordinador.documentos.aprobados') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Documentos
                        Aprobados</a>
                    <a href="{{ route('coordinador.certificados.index') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Certificados</a>
                @endrole

                @role('estudiante')
                    <a href="{{ route('estudiante.documentos.index') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Mis
                        Documentos</a>
                    <a href="{{ route('estudiante.certificados.index') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Mis
                        Certificados</a>
                    <a href="{{ route('estudiante.normativas.index') }}"
                        class="text-institutional hover:text-gold font-semibold transition-colors duration-400">Normativas</a>
                @endrole
            </div>

            {{-- Dropdown usuario y logout --}}
            <div class="ml-4 relative">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-institutional hover:text-gold focus:outline-none focus:ring-2 focus:ring-institutional rounded"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span>{{ Auth::user()?->name ?? 'Invitado' }}</span>
                                <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-institutional hover:bg-institutional-light transition-colors duration-400">Perfil</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-institutional hover:bg-institutional-light transition-colors duration-400">
                                    Cerrar sesión
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="btn-secondary">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Registrarse
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

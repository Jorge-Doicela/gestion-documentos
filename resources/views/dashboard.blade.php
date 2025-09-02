@extends('layouts.app')

@section('title', 'Panel Principal')

@section('content')
    <div class="container-custom mx-auto px-4 py-8 md:py-12 animate-fade-in font-sans text-gray-800">

        {{-- Encabezado Principal y Bienvenida --}}
        <div class="mb-12">
            @auth
                @php
                    $roleName = auth()->user()->roles->first()->name ?? 'Usuario';
                    $greetings = [
                        'Administrador General' => [
                            'title' => '¡Hola, Administrador!',
                            'subtitle' => 'Bienvenido al panel de gestión central.',
                            'icon' => 'fas fa-user-shield',
                        ],
                        'Coordinador de Prácticas' => [
                            'title' => '¡Hola, Coordinador!',
                            'subtitle' => 'Tu labor es clave para supervisar las prácticas.',
                            'icon' => 'fas fa-user-tie',
                        ],
                        'Tutor Académico' => [
                            'title' => '¡Hola, Tutor!',
                            'subtitle' => 'Bienvenido al panel de seguimiento de estudiantes.',
                            'icon' => 'fas fa-chalkboard-teacher',
                        ],
                        'Estudiante' => [
                            'title' => '¡Hola, Estudiante!',
                            'subtitle' => 'Bienvenido a tu portal de prácticas.',
                            'icon' => 'fas fa-user-graduate',
                        ],
                    ];
                    $roleInfo = $greetings[$roleName] ?? [
                        'title' => '¡Bienvenido!',
                        'subtitle' => '',
                        'icon' => 'fas fa-user-circle',
                    ];
                @endphp
                <div
                    class="bg-gradient-to-br from-institutional to-steel text-white p-6 md:p-8 rounded-xl shadow-2xl animate-slide-in-down">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <div class="text-center md:text-left mb-4 md:mb-0">
                            <h1 class="text-3xl lg:text-4xl font-display font-bold mb-1">
                                {{ $roleInfo['title'] }}
                            </h1>
                            <p class="text-lg font-light opacity-90 font-sans">
                                {{ $roleInfo['subtitle'] }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div
                                class="w-16 h-16 md:w-20 md:h-20 bg-white/20 rounded-full flex items-center justify-center shadow-inner float">
                                <i class="{{ $roleInfo['icon'] }} text-3xl md:text-4xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>

        {{-- Panel Estudiante --}}
        @role('Estudiante')
            @php
                $certificado = auth()->user()->certificado;
            @endphp

            {{-- Sección Certificado --}}
            @if ($certificado)
                <div
                    class="max-w-xl mx-auto mb-8 p-6 rounded-xl shadow-lg bg-success/20 border-l-4 border-success animate-scale-in text-center">
                    <h2 class="text-xl font-display font-semibold text-success mb-2">
                        <i class="fas fa-certificate mr-2"></i>¡Felicidades, tu certificado está listo!
                    </h2>
                    <p class="text-sm text-gray-700 mb-4">
                        Ya puedes descargar tu certificado oficial de prácticas. ¡Un logro bien merecido!
                    </p>
                    <a href="{{ route('estudiante.certificados.descargar', $certificado->uuid) }}"
                        class="btn-primary py-3 px-6 shadow-md transition-transform transform hover:scale-105 animate-pulse-gold inline-flex items-center space-x-2">
                        <i class="fas fa-download"></i>
                        <span>Descargar Certificado</span>
                    </a>
                </div>
            @else
                <div
                    class="max-w-xl mx-auto mb-8 p-6 rounded-xl shadow-lg bg-warning/20 border-l-4 border-warning animate-fade-in text-center">
                    <h2 class="text-xl font-display font-semibold text-warning mb-2">
                        <i class="fas fa-clock mr-2"></i>Certificado en Proceso
                    </h2>
                    <p class="text-sm text-gray-700">
                        Aún no puedes descargar tu certificado.
                    </p>
                </div>
            @endif

            {{-- Sección Documentos, Tipos y Normativas lado a lado --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

                {{-- Mis Documentos --}}
                <div>
                    <h2 class="text-2xl font-display font-bold mb-6 text-institutional border-b-2 border-institutional/20 pb-2">
                        Gestión de Documentos
                    </h2>
                    <a href="{{ route('estudiante.documentos.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-file-alt text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Mis Documentos</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">
                            Accede y gestiona tus documentos de prácticas.
                        </p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>
                </div>

                {{-- Tipos de Documento --}}
                <div>
                    <h2 class="text-2xl font-display font-bold mb-6 text-institutional border-b-2 border-institutional/20 pb-2">
                        Tipos de Documento
                    </h2>
                    <a href="{{ route('documentos.tipos.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-file-contract text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Tipos de Documento</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">
                            Consulta los tipos de documentos disponibles en el sistema.
                        </p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>
                </div>

                {{-- Normativas --}}
                <div>
                    <h2 class="text-2xl font-display font-bold mb-6 text-institutional border-b-2 border-institutional/20 pb-2">
                        Normativas
                    </h2>
                    <a href="{{ route('normativas.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-book-open text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Normativas</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">
                            Consulta las normativas aplicables a tus documentos de prácticas.
                        </p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>
                </div>

            </div>
        @endrole


        {{-- Panel Administrador General --}}
        @role('Administrador General')
            <div class="mb-12">
                <h2 class="text-2xl font-display font-bold mb-6 text-institutional border-b-2 border-institutional/20 pb-2">
                    Acciones Administrador
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('admin.users.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-users-cog text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Gestión de Usuarios</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Administra cuentas y roles de usuarios.</p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>
                    <a href="{{ route('admin.configuraciones.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-cog text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Configuración Global</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Gestiona parámetros y configuraciones del sistema.
                        </p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>
                    <a href="{{ route('admin.logs.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-file-alt text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Logs de Auditoría</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Consulta todas las acciones realizadas en el
                            sistema.
                        </p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>
                </div>
            </div>
        @endrole


        {{-- Panel Coordinador de Prácticas --}}
        @role('Coordinador de Prácticas')
            <div class="mb-12">
                <h2 class="text-2xl font-display font-bold mb-6 text-institutional border-b-2 border-institutional/20 pb-2">
                    Acciones Coordinador
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- CRUD Empresas --}}
                    <a href="{{ route('admin.empresas.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-building text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Empresas</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Gestiona las empresas vinculadas a las prácticas.</p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>

                    {{-- CRUD Plazas --}}
                    <a href="{{ route('admin.plazas.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-briefcase text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Plazas</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Gestiona las plazas disponibles para prácticas.</p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>

                    {{-- CRUD Convenios --}}
                    <a href="{{ route('admin.convenios.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-handshake text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Convenios</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Gestiona los convenios firmados con las empresas.</p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>

                    {{-- CRUD Tipos de Documento --}}
                    <a href="{{ route('admin.tipos-documento.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-file-contract text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Tipos de Documento</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Gestiona todos los tipos de documentos del sistema.
                        </p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>

                    {{-- CRUD Normativas --}}
                    <a href="{{ route('admin.normativas.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-book text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Normativas</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Gestiona las normativas aplicables a los documentos.
                        </p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>

                    {{-- Revisar documentos aprobados por tutor --}}
                    <a href="{{ route('coordinador.documentos.aprobados') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-clipboard-check text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Documentos Aprobados</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Revisa los documentos aprobados por los tutores.</p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>

                    {{--
<!-- Documentos aprobados por tutor -->
<a href="{{ route('coordinador.documentos.aprobados') }}"
    class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
    <i class="fas fa-folder-open text-4xl text-institutional mb-4"></i>
    <h3 class="text-xl font-display font-semibold mb-2">Revisar Documentos</h3>
    <p class="text-sm text-gray-600 mb-4 flex-grow">
        Gestiona y revisa los documentos subidos por tutores
    </p>
    <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
</a>
--}}


                    {{-- CRUD de Asignaciones --}}
                    <a href="{{ route('coordinador.asignaciones.index') }}"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-tasks text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Asignaciones</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Gestiona las asignaciones y planes de trabajo de
                            estudiantes.</p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </a>

                    {{-- Generar Certificados --}}
                    <button onclick="openModal('generarCertificadoModal')"
                        class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                        <i class="fas fa-certificate text-4xl text-institutional mb-4"></i>
                        <h3 class="text-xl font-display font-semibold mb-2">Generar Certificados</h3>
                        <p class="text-sm text-gray-600 mb-4 flex-grow">Selecciona un estudiante para generar su certificado
                            oficial.</p>
                        <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                    </button>


                </div>

                {{-- Modal Generar Certificado --}}
                <div id="generarCertificadoModal"
                    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl shadow-xl w-11/12 md:w-1/2 p-6 relative animate-fade-in-up">
                        <button onclick="closeModal('generarCertificadoModal')"
                            class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                        <h3 class="text-2xl font-bold text-institutional mb-4">Generar Certificado</h3>
                        <form action="{{ route('coordinador.certificados.generar', 0) }}" method="POST"
                            id="formGenerarCertificado">
                            @csrf
                            <label for="user_id" class="block mb-2 font-semibold">Selecciona un estudiante:</label>
                            <select name="user_id" id="user_id"
                                class="w-full p-3 rounded-md border border-gray-300 focus:border-institutional focus:ring-1 focus:ring-institutional mb-4">
                                @foreach (\App\Models\User::role('Estudiante')->get() as $estudiante)
                                    <option value="{{ $estudiante->id }}">{{ $estudiante->name }} - {{ $estudiante->email }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="btn-primary w-full py-3 rounded-md hover:scale-105 transition-transform">Generar
                                Certificado</button>
                        </form>
                    </div>
                </div>

                {{-- Scripts Modal --}}
                <script>
                    function openModal(id) {
                        document.getElementById(id).classList.remove('hidden');
                    }

                    function closeModal(id) {
                        document.getElementById(id).classList.add('hidden');
                    }

                    document.getElementById('formGenerarCertificado').addEventListener('submit', function(e) {
                        const select = document.getElementById('user_id');
                        const userId = select.value;
                        this.action = "{{ url('coordinador/certificados/generar') }}/" + userId;
                    });
                </script>
            @endrole


            {{-- Panel Tutor Académico --}}
            @role('Tutor Académico')
                <div class="mb-12">
                    <h2
                        class="text-2xl font-display font-bold mb-6 text-institutional border-b-2 border-institutional/20 pb-2">
                        Acciones Tutor
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        {{-- Mis Estudiantes --}}
                        <a href="{{ route('tutor.estudiantes.index') }}"
                            class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                            <i class="fas fa-users text-4xl text-institutional mb-4"></i>
                            <h3 class="text-xl font-display font-semibold mb-2">Mis Estudiantes</h3>
                            <p class="text-sm text-gray-600 mb-4 flex-grow">Gestiona y consulta la información de tus
                                estudiantes
                                asignados.</p>
                            <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                        </a>

                        {{-- Revisión de documentos --}}
                        <a href="{{ route('tutor.revision.index') }}"
                            class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                            <i class="fas fa-clipboard-check text-4xl text-institutional mb-4"></i>
                            <h3 class="text-xl font-display font-semibold mb-2">Revisión de Documentos</h3>
                            <p class="text-sm text-gray-600 mb-4 flex-grow">Revisa y evalúa los documentos enviados por tus
                                estudiantes.</p>
                            <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                        </a>

                        {{-- Historial de revisión --}}
                        <a href="{{ route('tutor.historial.index') }}"
                            class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                            <i class="fas fa-history text-4xl text-institutional mb-4"></i>
                            <h3 class="text-xl font-display font-semibold mb-2">Historial de Revisión</h3>
                            <p class="text-sm text-gray-600 mb-4 flex-grow">Consulta el historial completo de documentos
                                revisados.
                            </p>
                            <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                        </a>

                        {{--
<!-- Subir nuevo documento -->
<a href="{{ route('estudiante.documentos.create', ['tipoDocumento' => 1]) }}"
    class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
    <i class="fas fa-upload text-4xl text-institutional mb-4"></i>
    <h3 class="text-xl font-display font-semibold mb-2">Subir Documento</h3>
    <p class="text-sm text-gray-600 mb-4 flex-grow">
        Carga tu documento en formato PDF para la revisión del coordinador académico.
    </p>
    <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
</a>
--}}



                        {{-- Tipos de Documento --}}
                        <a href="{{ route('documentos.tipos.index') }}"
                            class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                            <i class="fas fa-file-contract text-4xl text-institutional mb-4"></i>
                            <h3 class="text-xl font-display font-semibold mb-2">Tipos de Documento</h3>
                            <p class="text-sm text-gray-600 mb-4 flex-grow">Consulta los tipos de documentos que debes
                                revisar.</p>
                            <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                        </a>

                        {{-- Normativas --}}
                        <a href="{{ route('normativas.index') }}"
                            class="card-hover glass p-6 rounded-xl shadow-lg text-center flex flex-col items-center justify-between">
                            <i class="fas fa-book-open text-4xl text-institutional mb-4"></i>
                            <h3 class="text-xl font-display font-semibold mb-2">Normativas</h3>
                            <p class="text-sm text-gray-600 mb-4 flex-grow">Consulta las normativas aplicables a tus
                                estudiantes.</p>
                            <span class="btn-primary w-full inline-block mt-auto">Acceder</span>
                        </a>

                    </div>
                </div>
            @endrole

        </div>
    @endsection

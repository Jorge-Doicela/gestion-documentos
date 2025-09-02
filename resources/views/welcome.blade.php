<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema de Prácticas Preprofesionales | ISTPET</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased text-white min-h-screen flex flex-col">

    <header class="w-full container-custom pt-6 pb-4 animate-fade-in-down">
        @if (Route::has('login'))
            <nav class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 bg-gradient-main rounded-xl flex items-center justify-center shadow-xl float">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V4a2 2 0 00-2-2H10a2 2 0 00-2 2v2m8 0H8m8 0l-1 12a2 2 0 01-2 1.87H9a2 2 0 01-2-1.87L8 6h8z">
                            </path>
                        </svg>
                    </div>
                    <div class="text-white">
                        <h2 class="font-bold text-lg font-display">ISTPET</h2>
                        <p class="text-xs text-steel-light font-sans">Prácticas Preprofesionales</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">
                            Panel de Control
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary">
                            Iniciar Sesión
                        </a>

                    @endauth
                </div>
            </nav>
        @endif
    </header>

    <main class="flex-grow flex items-center justify-center">
        <div class="text-center container-custom animate-fade-in-up">
            <div class="glass p-12 rounded-4xl shadow-3xl border border-institutional/20 mb-12">
                <div class="mb-8">
                    <h1
                        class="text-7xl font-extrabold font-display text-transparent bg-clip-text bg-gradient-gold
                        animate-pulse-accent mb-6">
                        ISTPET
                    </h1>
                    <h2 class="text-3xl font-bold font-display text-white mb-4">
                        Sistema Integral de Prácticas Preprofesionales
                    </h2>
                    <p class="text-xl text-steel-light font-sans font-medium mb-6">
                        Gestión Digital Completa
                    </p>
                </div>

                <p class="text-lg text-gray-200 leading-relaxed max-w-2xl mx-auto">
                    Plataforma digital integral que automatiza todo el ciclo de prácticas preprofesionales: desde la
                    postulación y asignación hasta la validación final y certificación oficial del Instituto Superior
                    Tecnológico Mayor Pedro Traversari.
                </p>
            </div>
            <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 mb-16 animate-fade-in-up">
                <div class="glass p-8 rounded-2xl border border-institutional/20 card-hover">
                    <div
                        class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-eco to-teal-600 rounded-xl mb-6 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold font-display text-white mb-4">Para Estudiantes</h3>
                    <ul class="text-gray-300 space-y-2 text-sm">
                        <li>✓ Gestión completa de tu proceso de prácticas</li>
                        <li>✓ Carga y seguimiento de documentos académicos</li>
                        <li>✓ Comunicación directa con tutores</li>
                        <li>✓ Descarga de certificación oficial</li>
                    </ul>
                </div>

                <div class="glass p-8 rounded-2xl border border-institutional/20 card-hover">
                    <div
                        class="flex items-center justify-center w-16 h-16 bg-gradient-main rounded-xl mb-6 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold font-display text-white mb-4">Para Tutores</h3>
                    <ul class="text-gray-300 space-y-2 text-sm">
                        <li>✓ Supervisión académica de estudiantes asignados</li>
                        <li>✓ Evaluación y retroalimentación estructurada</li>
                        <li>✓ Seguimiento del progreso de prácticas</li>
                        <li>✓ Validación de documentos académicos</li>
                    </ul>
                </div>

                <div class="glass p-8 rounded-2xl border border-institutional/20 card-hover">
                    <div
                        class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl mb-6 mx-auto group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold font-display text-white mb-4">Para Coordinadores</h3>
                    <ul class="text-gray-300 space-y-2 text-sm">
                        <li>✓ Validación final institucional</li>
                        <li>✓ Generación de certificados digitales</li>
                        <li>✓ Firma digital con timestamp</li>
                        <li>✓ Códigos QR de verificación</li>
                    </ul>
                </div>
            </div>

            <div class="max-w-4xl mx-auto mb-16 animate-fade-in-up">
                <div class="glass p-8 rounded-2xl border border-institutional/20">
                    <h3 class="text-2xl font-bold font-display text-white text-center mb-8">Flujo del Proceso</h3>
                    <div
                        class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 md:space-x-4">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 bg-eco rounded-full flex items-center justify-center text-white font-bold mb-3">
                                1</div>
                            <p class="text-gray-200 font-medium">Estudiante<br>Carga Documentos</p>
                        </div>
                        <div class="hidden md:block text-steel-light">→</div>
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 bg-institutional rounded-full flex items-center justify-center text-white font-bold mb-3">
                                2</div>
                            <p class="text-gray-200 font-medium">Tutor<br>Revisa y Valida</p>
                        </div>
                        <div class="hidden md:block text-steel-light">→</div>
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold mb-3">
                                3</div>
                            <p class="text-gray-200 font-medium">Coordinador<br>Aprueba Final</p>
                        </div>
                        <div class="hidden md:block text-steel-light">→</div>
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 bg-gold rounded-full flex items-center justify-center text-institutional-dark font-bold mb-3">
                                4</div>
                            <p class="text-gray-200 font-medium">Certificado<br>Digital Generado</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto mb-16 animate-fade-in-up">
                <div class="glass p-8 rounded-2xl border border-institutional/20">
                    <h3 class="text-2xl font-bold font-display text-white text-center mb-8">Características Principales
                    </h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-eco rounded-full flex-shrink-0 mt-1 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Documentos Seguros</h4>
                                <p class="text-gray-300 text-sm">Almacenamiento cifrado y rutas protegidas</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-institutional rounded-full flex-shrink-0 mt-1 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Trazabilidad Total</h4>
                                <p class="text-gray-300 text-sm">Seguimiento completo de cada documento</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-purple-500 rounded-full flex-shrink-0 mt-1 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Certificados Verificables</h4>
                                <p class="text-gray-300 text-sm">Con QR y firma digital SHA256</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-gold rounded-full flex-shrink-0 mt-1 flex items-center justify-center">
                                <svg class="w-3 h-3 text-institutional-dark" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Auditoría Completa</h4>
                                <p class="text-gray-300 text-sm">Logs de todas las acciones del sistema</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-2xl mx-auto text-center animate-fade-in-up">
                <div class="glass p-8 rounded-2xl border border-institutional/20">
                    <h3 class="text-2xl font-bold font-display text-white mb-4">¿Listo para comenzar?</h3>
                    <p class="text-gray-300 mb-6">
                        Inicia sesión con tu correo institucional para acceder a todas las funcionalidades del sistema.
                    </p>
                    @guest
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('login') }}" class="btn-primary">
                                Iniciar Sesión
                            </a>

                        </div>
                    @else
                        <a href="{{ url('/dashboard') }}" class="btn-primary inline-block">
                            Ir al Panel de Control
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </main>

    <footer class="py-8 text-center border-t border-institutional/20 mt-16">
        <div class="max-w-4xl mx-auto px-4">
            <div class="glass p-6 rounded-xl border border-institutional/20">
                <p class="text-sm text-gray-400 mb-2">
                    &copy; {{ date('Y') }} Instituto Superior Tecnológico Mayor Pedro Traversari (ISTPET)
                </p>
                <p class="text-xs text-gray-500">
                    Sistema de Gestión de Documentos Académicos - Prácticas Preprofesionales
                </p>
            </div>
        </div>
    </footer>

</body>

</html>

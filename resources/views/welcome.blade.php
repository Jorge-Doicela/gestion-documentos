<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bienvenido | ISTPET</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body
    class="font-sans antialiased bg-background-gradient min-h-screen text-institutional flex flex-col items-center justify-center">

    <header class="w-full container-custom mt-6 mb-12 animate-fade-in-down">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">
                        Panel de Control
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary">
                        Iniciar Sesión
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="text-center px-4 py-8 max-w-2xl animate-fade-in">
        <div class="glass p-8 rounded-2xl shadow-xl border border-institutional/20">
            <h1 class="text-6xl font-extrabold font-display text-gradient-istpet animate-pulse-gold mb-4">
                ISTPET
            </h1>
            <p class="text-xl text-white font-medium mb-6 animate-fade-in-up">
                Sistema de Gestión de Documentos
            </p>
            <p class="text-lg text-white font-light leading-relaxed animate-fade-in-up">
                ¡Bienvenido! Este es el portal oficial del Instituto Superior Tecnológico Mayor Pedro Traversari. Aquí
                podrás gestionar tus documentos, acceder a normativas y mucho más.
            </p>
        </div>
    </main>

    <footer class="mt-auto py-6 text-center text-sm text-gray-400 animate-fade-in-up">
        &copy; {{ date('Y') }} {{ config('app.name', 'Gestion Documentos') }}. Todos los derechos reservados.
    </footer>

</body>

</html>

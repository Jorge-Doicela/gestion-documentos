<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Gestion Documentos') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Parsley.js CSS (opcional si quieres estilos por defecto) -->
    <link href="https://cdn.jsdelivr.net/npm/parsleyjs/src/parsley.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 min-h-screen">
    <div class="flex flex-col min-h-screen">
        @include('layouts.navigation')

        <!-- Header (opcional) -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Contenido principal -->
        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @yield('content')
        </main>

        <!-- Footer simple -->
        <footer class="bg-white shadow-inner mt-auto">
            <div class="max-w-7xl mx-auto py-4 px-4 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'Gestion Documentos') }}. Todos los derechos
                reservados.
            </div>
        </footer>
    </div>

    <!-- Parsley.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs"></script>

    @stack('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>

</body>

</html>

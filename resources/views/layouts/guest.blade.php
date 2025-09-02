<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ISTPET') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen flex flex-col items-center justify-center font-sans antialiased text-white bg-gradient-main bg-cover bg-fixed bg-center relative overflow-hidden">
    <div class="absolute inset-0 w-full h-full -z-10">
        <ul class="bubbles">
            <li class="bg-institutional-light"></li>
            <li class="bg-steel-light"></li>
            <li class="bg-gold-light"></li>
            <li class="bg-institutional-light"></li>
            <li class="bg-steel-light"></li>
            <li class="bg-gold-light"></li>
            <li class="bg-institutional-light"></li>
            <li class="bg-steel-light"></li>
            <li class="bg-gold-light"></li>
            <li class="bg-institutional-light"></li>
        </ul>
    </div>
    <div class="container-custom flex flex-col items-center justify-center z-10">
        {{-- Contenedor principal del formulario con los estilos de glassmorphism --}}
        <div
            class="w-full sm:max-w-xl p-8 rounded-4xl shadow-3xl glass-dark border border-institutional-light animate-fade-in-up card-hover">
            <div class="text-center mb-6">
                {{-- Se usa la tipografía 'display' y el color 'gold' definido en tu configuración --}}
                <h1 class="text-3xl font-display font-bold text-gold-light mb-2 animate-pulse-accent">Bienvenido</h1>
                {{-- Se aplica la tipografía 'sans' por defecto con un color claro --}}
                <p class="text-lg font-sans font-light text-steel-light">Inicia sesión en tu cuenta</p>
            </div>

            {{ $slot }}
        </div>
    </div>
</body>

</html>

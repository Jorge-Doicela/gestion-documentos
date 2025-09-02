<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | ISTPET</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-background-gradient">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="animate-fade-in-down">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-institutional animate-bounce-soft" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 glass overflow-hidden rounded-lg animate-scale-in-center">
            {{ $slot }}
        </div>
    </div>
</body>

</html>

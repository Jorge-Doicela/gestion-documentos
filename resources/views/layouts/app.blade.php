<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Gestion Documentos') }} | ISTPET</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-institutional-light min-h-screen">
    <div class="flex flex-col min-h-screen">
        @include('layouts.navigation')

        @isset($header)
            <header class="shadow-lg glass-dark animate-fade-in">
                <div class="container-custom py-8 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-grow container-custom py-6">
            {{-- Aquí se mostrará el contenido principal, tarjetas, tablas, etc. --}}
            @yield('content')
        </main>

        <footer class="bg-institutional-dark shadow-inner mt-auto text-white animate-fade-in-up">
            <div class="container-custom py-6 text-center text-sm">
                <span class="text-gold font-bold">ISTPET - "Atrévete a Cambiar el Mundo"</span>
                <br>
                &copy; {{ date('Y') }} Instituto Superior Tecnológico Mayor Pedro Traversari. Todos los derechos
                reservados.
            </div>
        </footer>
    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar tooltips con Tippy.js
            tippy('[data-tippy-content]', {
                animation: 'scale',
                theme: 'light-border',
                delay: [100, 100],
                maxWidth: 400,
                allowHTML: true,
            });

            // Confirmación elegante con SweetAlert2 para formularios de eliminación
            const formulariosEliminar = document.querySelectorAll('.form-eliminar');
            formulariosEliminar.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: '¿Estás seguro que quieres eliminar esta normativa?',
                        text: "Esta acción no se puede deshacer.",
                        icon: 'warning',
                        confirmButtonColor: '#EF4444', // Color 'danger'
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const submitBtn = form.querySelector('button[type="submit"]');
                            if (submitBtn) {
                                submitBtn.disabled = true;
                                submitBtn.textContent = 'Eliminando...';
                            }
                            form.submit();
                        }
                    });
                });
            });

            // Mostrar alertas flash con SweetAlert2
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    timer: 4000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
</body>

</html>

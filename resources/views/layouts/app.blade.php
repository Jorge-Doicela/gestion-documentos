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

    <!-- Estilos para animación y apariencia Tippy.js -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 min-h-screen">
    <div class="flex flex-col min-h-screen">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            {{-- Eliminé el bloque de alertas flash aquí porque las mostramos con SweetAlert2 --}}

            @yield('content')
        </main>

        <footer class="bg-white shadow-inner mt-auto">
            <div class="max-w-7xl mx-auto py-4 px-4 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'Gestion Documentos') }}. Todos los derechos
                reservados.
            </div>
        </footer>
    </div>

    <!-- Parsley.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs"></script>

    <!-- CKEditor 5 Classic -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    @stack('scripts')

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Popper.js necesario para Tippy.js -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>

    <!-- Tippy.js -->
    <script src="https://unpkg.com/tippy.js@6"></script>

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
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
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

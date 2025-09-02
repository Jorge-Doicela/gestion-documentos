@extends('layouts.app')

@section('header')
    <h2 class="font-display font-bold text-4xl text-institutional-dark leading-tight animate-fade-in-up">
        Crear Usuario
    </h2>
    <p class="text-steel font-body text-md mt-2 animate-fade-in-down">
        Complete el formulario para registrar un nuevo usuario en el sistema.
    </p>
@endsection

@section('content')
    <div class="container-custom py-8 px-6 bg-white rounded-4xl shadow-soft-lg animate-fade-in">
        {{-- Mensajes de feedback --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-success text-white rounded-lg shadow-md animate-fade-in">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 bg-danger text-white rounded-lg shadow-md animate-fade-in">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Formulario de creación --}}
        <form id="form-usuario" action="{{ route('admin.users.store') }}" method="POST" data-parsley-validate>
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                {{-- Nombre --}}
                <div class="col-span-1">
                    <label for="name" class="block font-semibold text-sm text-institutional mb-1">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        data-parsley-trigger="change" data-parsley-required-message="El nombre es obligatorio."
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('name')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="col-span-1">
                    <label for="email" class="block font-semibold text-sm text-institutional mb-1">Correo
                        Electrónico</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        data-parsley-type="email" data-parsley-required-message="El correo es obligatorio."
                        data-parsley-type-message="El correo no tiene un formato válido." data-parsley-trigger="change"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('email')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div class="col-span-1">
                    <label for="telefono" class="block font-semibold text-sm text-institutional mb-1">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                        data-parsley-pattern="^[0-9]{9,10}$"
                        data-parsley-pattern-message="El número de teléfono debe tener 9 o 10 dígitos numéricos."
                        data-parsley-trigger="change"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('telefono')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dirección --}}
                <div class="col-span-1">
                    <label for="direccion" class="block font-semibold text-sm text-institutional mb-1">Dirección</label>
                    <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('direccion')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Identificación --}}
                <div class="col-span-1">
                    <label for="identificacion"
                        class="block font-semibold text-sm text-institutional mb-1">Identificación</label>
                    <input type="text" name="identificacion" id="identificacion" value="{{ old('identificacion') }}"
                        required data-parsley-required-message="La identificación es obligatoria."
                        data-parsley-trigger="change"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('identificacion')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha de nacimiento --}}
                <div class="col-span-1">
                    <label for="fecha_nacimiento" class="block font-semibold text-sm text-institutional mb-1">Fecha de
                        Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento') }}" data-parsley-dateiso="true" data-parsley-fecha-pasada
                        data-parsley-dateiso-message="La fecha debe tener formato válido (YYYY-MM-DD)."
                        data-parsley-fecha-pasada-message="La fecha no puede ser futura." data-parsley-trigger="change"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('fecha_nacimiento')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Género --}}
                <div class="col-span-1">
                    <label for="genero" class="block font-semibold text-sm text-institutional mb-1">Género</label>
                    <select name="genero" id="genero"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 bg-white focus:ring-gold-dark focus:border-gold-dark transition duration-400">
                        <option value="" disabled selected>Seleccione un género</option>
                        @foreach (['Masculino', 'Femenino', 'Otro'] as $genero)
                            <option value="{{ $genero }}" {{ old('genero') == $genero ? 'selected' : '' }}>
                                {{ $genero }}
                            </option>
                        @endforeach
                    </select>
                    @error('genero')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Carrera --}}
                <div class="col-span-1">
                    <label for="carrera_id" class="block font-semibold text-sm text-institutional mb-1">Carrera</label>
                    <select name="carrera_id" id="carrera_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 bg-white focus:ring-gold-dark focus:border-gold-dark transition duration-400">
                        <option value="" selected>Seleccione una carrera</option>
                        @foreach ($carreras as $id => $nombre)
                            <option value="{{ $id }}" {{ old('carrera_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('carrera_id')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tutor --}}
                <div class="col-span-1">
                    <label for="tutor_id" class="block font-semibold text-sm text-institutional mb-1">Tutor Asignado
                        (opcional)</label>
                    <select name="tutor_id" id="tutor_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 bg-white focus:ring-gold-dark focus:border-gold-dark transition duration-400">
                        <option value="" selected>Sin tutor asignado</option>
                        @foreach ($tutores as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('tutor_id', $user->tutor_id ?? '') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tutor_id')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Rol --}}
                <div class="col-span-1">
                    <label for="role" class="block font-semibold text-sm text-institutional mb-1">Rol</label>
                    <select name="role" id="role" required
                        data-parsley-required-message="Debe seleccionar un rol." data-parsley-trigger="change"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 bg-white focus:ring-gold-dark focus:border-gold-dark transition duration-400">
                        <option value="" disabled selected>Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="col-span-1">
                    <label for="password" class="block font-semibold text-sm text-institutional mb-1">Contraseña</label>
                    <input type="password" name="password" id="password" required data-parsley-minlength="6"
                        data-parsley-required-message="La contraseña es obligatoria."
                        data-parsley-minlength-message="La contraseña debe tener al menos 6 caracteres."
                        data-parsley-trigger="change"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('password')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div class="col-span-1">
                    <label for="password_confirmation" class="block font-semibold text-sm text-institutional mb-1">
                        Confirmar Contraseña
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        data-parsley-equalto="#password" data-parsley-required-message="Debe confirmar la contraseña."
                        data-parsley-equalto-message="Las contraseñas no coinciden." data-parsley-trigger="change"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('password_confirmation')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex items-center gap-3">
                <button type="submit" class="btn-primary flex items-center gap-2 animate-pulse-accent">
                    <i class="fas fa-user-plus"></i> Crear
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary flex items-center gap-2">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/i18n/es.js"></script>
    <script>
        // Validador para fecha en el pasado
        window.Parsley.addValidator('fechaPasada', {
            validateString: function(value) {
                if (!value) return true; // Opcional si no es campo requerido
                const fecha = new Date(value);
                const hoy = new Date();
                fecha.setHours(0, 0, 0, 0);
                hoy.setHours(0, 0, 0, 0);
                return fecha <= hoy;
            },
            messages: {
                es: 'La fecha no puede ser futura.'
            }
        });

        // Configurar Parsley.js en español y con focus en el primer error
        window.Parsley.setLocale('es');
        window.Parsley.options.focus = 'first';
    </script>
@endpush

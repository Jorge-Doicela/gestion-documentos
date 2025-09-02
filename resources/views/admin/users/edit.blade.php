@extends('layouts.app')

@section('header')
    <h2 class="font-display font-bold text-4xl text-institutional-dark leading-tight animate-fade-in-up">
        ✏️ Editar Usuario
    </h2>
@endsection

@section('content')
    <div class="container-custom py-8 animate-fade-in">
        <form id="form-usuario" action="{{ route('admin.users.update', $user) }}" method="POST" data-parsley-validate
            class="bg-white p-6 md:p-8 rounded-2xl shadow-soft-lg space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                {{-- Nombre --}}
                <div class="col-span-1">
                    <label for="name" class="block font-semibold text-sm text-institutional mb-1">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
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
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
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
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $user->telefono) }}"
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
                    <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $user->direccion) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('direccion')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Identificación --}}
                <div class="col-span-1">
                    <label for="identificacion"
                        class="block font-semibold text-sm text-institutional mb-1">Identificación</label>
                    <input type="text" name="identificacion" id="identificacion"
                        value="{{ old('identificacion', $user->identificacion) }}" required
                        data-parsley-required-message="La identificación es obligatoria." data-parsley-trigger="change"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('identificacion')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha de Nacimiento --}}
                <div class="col-span-1">
                    <label for="fecha_nacimiento" class="block font-semibold text-sm text-institutional mb-1">Fecha de
                        Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento', $user->fecha_nacimiento ? $user->fecha_nacimiento->format('Y-m-d') : '') }}"
                        data-parsley-dateiso="true" data-parsley-fecha-pasada
                        data-parsley-dateiso-message="La fecha debe tener formato válido (YYYY-MM-DD)."
                        data-parsley-fecha-pasada-message="La fecha no puede ser futura."
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
                        <option value="" disabled>Seleccione un género</option>
                        @foreach (['Masculino', 'Femenino', 'Otro'] as $genero)
                            <option value="{{ $genero }}"
                                {{ old('genero', $user->genero) == $genero ? 'selected' : '' }}>
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
                        <option value="">Seleccione una carrera</option>
                        @foreach ($carreras as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ old('carrera_id', $user->carrera_id) == $id ? 'selected' : '' }}>
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
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 bg-white focus:ring-gold-dark focus:border-gold-dark transition duration-400">
                        @foreach ($roles as $role)
                            <option value="{{ $role }}"
                                {{ old('role', $user->roles->pluck('name')->first()) == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nueva Contraseña --}}
                <div class="col-span-1">
                    <label for="password" class="block font-semibold text-sm text-institutional mb-1">Nueva Contraseña
                        (opcional)</label>
                    <input type="password" name="password" id="password" data-parsley-minlength="6"
                        data-parsley-minlength-message="La contraseña debe tener al menos 6 caracteres."
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('password')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar Nueva Contraseña --}}
                <div class="col-span-1">
                    <label for="password_confirmation"
                        class="block font-semibold text-sm text-institutional mb-1">Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        data-parsley-equalto="#password" data-parsley-equalto-message="Las contraseñas no coinciden."
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400" />
                    @error('password_confirmation')
                        <p class="text-danger text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex flex-wrap justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary" title="Actualizar usuario">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/i18n/es.js"></script>
    <script>
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

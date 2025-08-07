@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Usuario</h2>
@endsection

@section('content')
    <div class="max-w-lg mx-auto py-6 sm:px-6 lg:px-8">
        <form id="form-usuario" action="{{ route('admin.users.store') }}" method="POST" data-parsley-validate>
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <label for="name" class="block font-medium text-sm text-gray-700">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    data-parsley-trigger="change" data-parsley-required-message="El nombre es obligatorio."
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block font-medium text-sm text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    data-parsley-type="email" data-parsley-required-message="El correo es obligatorio."
                    data-parsley-type-message="El correo no tiene un formato válido." data-parsley-trigger="change"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div class="mb-4">
                <label for="telefono" class="block font-medium text-sm text-gray-700">Teléfono</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                    data-parsley-pattern="^[0-9]{9,10}$"
                    data-parsley-pattern-message="El número de teléfono debe tener 9 o 10 dígitos numéricos."
                    data-parsley-trigger="change"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('telefono')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dirección -->
            <div class="mb-4">
                <label for="direccion" class="block font-medium text-sm text-gray-700">Dirección</label>
                <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('direccion')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Identificación -->
            <div class="mb-4">
                <label for="identificacion" class="block font-medium text-sm text-gray-700">Identificación</label>
                <input type="text" name="identificacion" id="identificacion" value="{{ old('identificacion') }}" required
                    data-parsley-required-message="La identificación es obligatoria." data-parsley-trigger="change"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('identificacion')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="mb-4">
                <label for="fecha_nacimiento" class="block font-medium text-sm text-gray-700">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                    data-parsley-dateiso="true" data-parsley-fecha-pasada
                    data-parsley-dateiso-message="La fecha debe tener formato válido (YYYY-MM-DD)."
                    data-parsley-fecha-pasada-message="La fecha no puede ser futura." data-parsley-trigger="change"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('fecha_nacimiento')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Género -->
            <div class="mb-4">
                <label for="genero" class="block font-medium text-sm text-gray-700">Género</label>
                <select name="genero" id="genero"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" disabled selected>Seleccione un género</option>
                    @foreach (['Masculino', 'Femenino', 'Otro'] as $genero)
                        <option value="{{ $genero }}" {{ old('genero') == $genero ? 'selected' : '' }}>
                            {{ $genero }}
                        </option>
                    @endforeach
                </select>
                @error('genero')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Carrera -->
            <div class="mb-4">
                <label for="carrera_id" class="block font-medium text-sm text-gray-700">Carrera</label>
                <select name="carrera_id" id="carrera_id" data-parsley-required="false"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" selected>Seleccione una carrera</option>
                    @foreach ($carreras as $id => $nombre)
                        <option value="{{ $id }}" {{ old('carrera_id') == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </select>
                @error('carrera_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Tutor -->
            <div class="mb-4">
                <label for="tutor_id" class="block font-medium text-sm text-gray-700">Tutor Asignado (opcional)</label>
                <select name="tutor_id" id="tutor_id"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" selected>Sin tutor asignado</option>
                    @foreach ($tutores as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('tutor_id', $user->tutor_id ?? '') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('tutor_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rol -->
            <div class="mb-4">
                <label for="role" class="block font-medium text-sm text-gray-700">Rol</label>
                <select name="role" id="role" required data-parsley-required-message="Debe seleccionar un rol."
                    data-parsley-trigger="change"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" disabled selected>Seleccione un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label for="password" class="block font-medium text-sm text-gray-700">Contraseña</label>
                <input type="password" name="password" id="password" required data-parsley-minlength="6"
                    data-parsley-required-message="La contraseña es obligatoria."
                    data-parsley-minlength-message="La contraseña debe tener al menos 6 caracteres."
                    data-parsley-trigger="change"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-4">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirmar
                    Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    data-parsley-equalto="#password" data-parsley-required-message="Debe confirmar la contraseña."
                    data-parsley-equalto-message="Las contraseñas no coinciden." data-parsley-trigger="change"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Crear
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="ml-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <!-- Parsley.js -->
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs"></script>
    <script>
        window.Parsley.addValidator('fechaPasada', {
            validateString: function(value) {
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
    </script>
@endpush

@extends('layouts.app')
@section('title', 'Editar Empresa')

@section('content')
    <div class="container-custom py-6 px-4 sm:px-6 lg:px-8 animate-fade-in-up">

        <div class="max-w-2xl mx-auto glass p-8 rounded-lg shadow-soft-lg animate-fade-in">

            <h1 class="text-3xl font-display font-bold text-institutional-dark mb-6 text-center text-gradient-istpet">
                ✏️ Editar Empresa
            </h1>

            @if ($errors->any())
                <div
                    class="p-4 mb-6 rounded-lg shadow-soft-lg animate-slide-in-right bg-danger/20 text-danger font-semibold border-l-4 border-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong class="font-bold">Se encontraron errores:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.empresas.update', $empresa) }}" method="POST" class="space-y-6" novalidate>
                @csrf
                @method('PUT')

                <div>
                    <label for="nombre" class="block font-semibold text-institutional-dark mb-1">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $empresa->nombre) }}"
                        required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('nombre') border-danger focus:ring-danger @enderror"
                        aria-invalid="@error('nombre') true @else false @enderror" />
                    @error('nombre')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ruc" class="block font-semibold text-institutional-dark mb-1">RUC</label>
                    <input type="text" name="ruc" id="ruc" value="{{ old('ruc', $empresa->ruc) }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('ruc') border-danger focus:ring-danger @enderror"
                        aria-invalid="@error('ruc') true @else false @enderror" />
                    @error('ruc')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="direccion" class="block font-semibold text-institutional-dark mb-1">Dirección</label>
                    <input type="text" name="direccion" id="direccion"
                        value="{{ old('direccion', $empresa->direccion) }}"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800" />
                </div>

                <div>
                    <label for="telefono" class="block font-semibold text-institutional-dark mb-1">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $empresa->telefono) }}"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800" />
                </div>

                <div>
                    <label for="email" class="block font-semibold text-institutional-dark mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $empresa->email) }}"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800" />
                </div>

                <div>
                    <label for="contacto" class="block font-semibold text-institutional-dark mb-1">Contacto</label>
                    <input type="text" name="contacto" id="contacto" value="{{ old('contacto', $empresa->contacto) }}"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800" />
                </div>

                <div class="flex flex-wrap gap-3 justify-end">
                    <button type="submit" class="btn-primary flex items-center gap-2">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="{{ route('admin.empresas.index') }}" class="btn-secondary flex items-center gap-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

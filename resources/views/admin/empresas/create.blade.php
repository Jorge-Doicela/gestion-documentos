@extends('layouts.app')
@section('title', 'Nueva Empresa')

@section('content')
    <div class="container-custom py-6 px-4 sm:px-6 lg:px-8 animate-fade-in-up">

        <div class="max-w-2xl mx-auto glass p-8 rounded-lg shadow-soft-lg animate-fade-in">

            <h1 class="text-3xl font-display font-bold text-institutional-dark mb-2 text-center text-gradient-istpet">
                Registrar Nueva Empresa
            </h1>
            <p class="text-institutional text-sm font-sans text-center mb-6">
                Completa el formulario para agregar una nueva empresa al sistema.
            </p>

            @if ($errors->any())
                <div
                    class="p-4 mb-6 rounded-lg shadow-soft-lg animate-slide-in-right bg-danger/20 text-danger font-semibold border-l-4 border-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.empresas.store') }}" method="POST" class="space-y-5" data-parsley-validate>
                @csrf

                <div>
                    <label for="nombre" class="block font-semibold text-institutional-dark mb-1">
                        Nombre <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('nombre') border-danger @enderror"
                        placeholder="Nombre de la empresa" autocomplete="off"
                        data-parsley-required-message="El nombre es obligatorio.">
                    @error('nombre')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ruc" class="block font-semibold text-institutional-dark mb-1">
                        RUC <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="ruc" id="ruc" value="{{ old('ruc') }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('ruc') border-danger @enderror"
                        placeholder="Ej: 1790012345001" autocomplete="off"
                        data-parsley-required-message="El RUC es obligatorio.">
                    @error('ruc')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="direccion" class="block font-semibold text-institutional-dark mb-1">Dirección</label>
                    <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800"
                        placeholder="Calle, ciudad, provincia">
                </div>

                <div>
                    <label for="telefono" class="block font-semibold text-institutional-dark mb-1">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800"
                        placeholder="Ej: +593 99 123 4567">
                </div>

                <div>
                    <label for="email" class="block font-semibold text-institutional-dark mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800"
                        placeholder="empresa@dominio.com">
                </div>

                <div>
                    <label for="contacto" class="block font-semibold text-institutional-dark mb-1">Contacto</label>
                    <input type="text" name="contacto" id="contacto" value="{{ old('contacto') }}"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800"
                        placeholder="Nombre del representante">
                </div>

                <div class="flex justify-end gap-3">
                    <button type="submit" class="btn-primary animate-glow flex items-center gap-2">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('admin.empresas.index') }}" class="btn-secondary flex items-center gap-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

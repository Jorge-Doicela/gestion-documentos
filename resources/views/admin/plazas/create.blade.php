@extends('layouts.app')
@section('title', 'Nueva Plaza')

@section('content')
    <div class="container-custom py-6 px-4 sm:px-6 lg:px-8 animate-fade-in-up">

        <div class="max-w-2xl mx-auto glass p-8 rounded-lg shadow-soft-lg animate-fade-in">

            <h1 class="text-3xl font-display font-bold text-institutional-dark mb-2 text-center text-gradient-istpet">
                Registrar Nueva Plaza
            </h1>
            <p class="text-institutional text-sm font-sans text-center mb-6">
                Completa el formulario para agregar una nueva plaza de práctica profesional.
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

            <form action="{{ route('admin.plazas.store') }}" method="POST" class="space-y-5" data-parsley-validate>
                @csrf

                <div>
                    <label for="empresa_id" class="block font-semibold text-institutional-dark mb-1">
                        Empresa <span class="text-danger">*</span>
                    </label>
                    <select name="empresa_id" id="empresa_id" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('empresa_id') border-danger @enderror"
                        data-parsley-required-message="Debes seleccionar una empresa.">
                        <option value="">Seleccionar empresa</option>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                {{ $empresa->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('empresa_id')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="area" class="block font-semibold text-institutional-dark mb-1">
                        Área de práctica <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="area" id="area" value="{{ old('area') }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('area') border-danger @enderror"
                        placeholder="Ej: Desarrollo de Software"
                        data-parsley-required-message="El área de práctica es obligatoria.">
                    @error('area')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="periodo_academico" class="block font-semibold text-institutional-dark mb-1">
                        Período académico <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="periodo_academico" id="periodo_academico"
                        value="{{ old('periodo_academico') }}" placeholder="Ej: 2025-I" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('periodo_academico') border-danger @enderror"
                        data-parsley-required-message="El período académico es obligatorio.">
                    @error('periodo_academico')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="vacantes" class="block font-semibold text-institutional-dark mb-1">
                        Vacantes <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="vacantes" id="vacantes" value="{{ old('vacantes', 1) }}" min="1"
                        required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('vacantes') border-danger @enderror"
                        data-parsley-required-message="El número de vacantes es obligatorio."
                        data-parsley-min-message="El número de vacantes debe ser al menos 1.">
                    @error('vacantes')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="requisitos" class="block font-semibold text-institutional-dark mb-1">Requisitos</label>
                    <textarea name="requisitos" id="requisitos" rows="4"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800"
                        placeholder="Ej: Conocimientos en Laravel, Git, trabajo en equipo">{{ old('requisitos') }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="submit" class="btn-primary animate-glow flex items-center gap-2">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('admin.plazas.index') }}" class="btn-secondary flex items-center gap-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

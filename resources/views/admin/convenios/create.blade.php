@extends('layouts.app')
@section('title', 'Nuevo Convenio')

@section('content')
    <div class="container-custom py-6 px-4 sm:px-6 lg:px-8 animate-fade-in-up">

        <div class="max-w-2xl mx-auto glass p-8 rounded-lg shadow-soft-lg animate-fade-in">

            <h1 class="text-3xl font-display font-bold text-institutional-dark mb-2 text-center text-gradient-istpet">
                Registrar Nuevo Convenio
            </h1>
            <p class="text-institutional text-sm font-sans text-center mb-6">
                Completa el formulario para registrar un convenio con una empresa.
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

            <form action="{{ route('admin.convenios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label for="empresa_id" class="block font-semibold text-institutional-dark mb-1">
                        Empresa <span class="text-danger">*</span>
                    </label>
                    <select name="empresa_id" id="empresa_id" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('empresa_id') border-danger @enderror">
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
                    <label for="pdf_ruta" class="block font-semibold text-institutional-dark mb-1">
                        PDF del Convenio <span class="text-danger">*</span>
                    </label>
                    <input type="file" name="pdf_ruta" id="pdf_ruta" accept="application/pdf" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-institutional file:text-white
                    hover:file:bg-institutional-dark
                    @error('pdf_ruta') border-danger @enderror">
                    @error('pdf_ruta')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Solo archivos PDF. Tamaño máximo recomendado: 5MB.</p>
                </div>

                <div>
                    <label for="fecha_inicio" class="block font-semibold text-institutional-dark mb-1">
                        Fecha de Inicio <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('fecha_inicio') border-danger @enderror">
                    @error('fecha_inicio')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_fin" class="block font-semibold text-institutional-dark mb-1">
                        Fecha de Fin <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('fecha_fin') border-danger @enderror">
                    @error('fecha_fin')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <button type="submit" class="btn-primary animate-glow flex items-center gap-2">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('admin.convenios.index') }}" class="btn-secondary flex items-center gap-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

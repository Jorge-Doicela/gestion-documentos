@extends('layouts.app')
@section('title', 'Editar Convenio')

@section('content')
    <div class="container-custom py-6 px-4 sm:px-6 lg:px-8 animate-fade-in-up">

        <div class="max-w-2xl mx-auto glass p-8 rounded-lg shadow-soft-lg animate-fade-in">

            <h1 class="text-3xl font-display font-bold text-institutional-dark mb-6 text-center text-gradient-istpet">
                ✏️ Editar Convenio
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

            <form action="{{ route('admin.convenios.update', $convenio) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="empresa_id" class="block font-semibold text-institutional-dark mb-1">Empresa</label>
                    <select name="empresa_id" id="empresa_id" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('empresa_id') border-danger focus:ring-danger @enderror">
                        <option value="">Seleccionar empresa</option>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id }}"
                                {{ old('empresa_id', $convenio->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                {{ $empresa->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('empresa_id')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pdf_ruta" class="block font-semibold text-institutional-dark mb-1">PDF del Convenio</label>
                    @if ($convenio->pdf_ruta)
                        <a href="{{ asset('storage/' . $convenio->pdf_ruta) }}" target="_blank"
                            class="text-info underline mb-2 inline-block hover:text-info-dark transition font-semibold">
                            <i class="fas fa-file-pdf mr-1"></i> Ver PDF actual
                        </a>
                    @endif
                    <input type="file" name="pdf_ruta" id="pdf_ruta" accept="application/pdf"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-institutional file:text-white
                    hover:file:bg-institutional-dark
                    @error('pdf_ruta') border-danger focus:ring-danger @enderror">
                    @error('pdf_ruta')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_inicio" class="block font-semibold text-institutional-dark mb-1">Fecha de
                        Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio"
                        value="{{ old('fecha_inicio', $convenio->fecha_inicio->format('Y-m-d')) }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('fecha_inicio') border-danger focus:ring-danger @enderror">
                    @error('fecha_inicio')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_fin" class="block font-semibold text-institutional-dark mb-1">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin"
                        value="{{ old('fecha_fin', $convenio->fecha_fin->format('Y-m-d')) }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('fecha_fin') border-danger focus:ring-danger @enderror">
                    @error('fecha_fin')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-3 justify-end">
                    <button type="submit" class="btn-primary flex items-center gap-2">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="{{ route('admin.convenios.index') }}" class="btn-secondary flex items-center gap-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

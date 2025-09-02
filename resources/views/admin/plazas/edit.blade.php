@extends('layouts.app')
@section('title', 'Editar Plaza')

@section('content')
    <div class="container-custom py-6 px-4 sm:px-6 lg:px-8 animate-fade-in-up">

        <div class="max-w-2xl mx-auto glass p-8 rounded-lg shadow-soft-lg animate-fade-in">

            <h1 class="text-3xl font-display font-bold text-institutional-dark mb-6 text-center text-gradient-istpet">
                ✏️ Editar Plaza
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

            <form action="{{ route('admin.plazas.update', $plaza) }}" method="POST" class="space-y-6" novalidate>
                @csrf
                @method('PUT')

                <div>
                    <label for="empresa_id" class="block font-semibold text-institutional-dark mb-1">Empresa</label>
                    <select name="empresa_id" id="empresa_id" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('empresa_id') border-danger focus:ring-danger @enderror">
                        <option value="">Seleccionar empresa</option>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id }}"
                                {{ old('empresa_id', $plaza->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                {{ $empresa->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('empresa_id')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="area" class="block font-semibold text-institutional-dark mb-1">Área de práctica</label>
                    <input type="text" name="area" id="area" value="{{ old('area', $plaza->area) }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('area') border-danger focus:ring-danger @enderror" />
                    @error('area')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="periodo_academico" class="block font-semibold text-institutional-dark mb-1">Período
                        académico</label>
                    <input type="text" name="periodo_academico" id="periodo_academico"
                        value="{{ old('periodo_academico', $plaza->periodo_academico) }}" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('periodo_academico') border-danger focus:ring-danger @enderror" />
                    @error('periodo_academico')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="vacantes" class="block font-semibold text-institutional-dark mb-1">Vacantes</label>
                    <input type="number" name="vacantes" id="vacantes" value="{{ old('vacantes', $plaza->vacantes) }}"
                        min="1" required
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('vacantes') border-danger focus:ring-danger @enderror" />
                    @error('vacantes')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="requisitos" class="block font-semibold text-institutional-dark mb-1">Requisitos</label>
                    <textarea name="requisitos" id="requisitos" rows="4"
                        class="w-full border border-steel-light rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-dark focus:border-gold transition bg-white text-gray-800 @error('requisitos') border-danger focus:ring-danger @enderror">{{ old('requisitos', $plaza->requisitos) }}</textarea>
                    @error('requisitos')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-3 justify-end">
                    <button type="submit" class="btn-primary flex items-center gap-2">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="{{ route('admin.plazas.index') }}" class="btn-secondary flex items-center gap-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

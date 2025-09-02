@extends('layouts.app')

@section('header')
    <h1 class="font-display font-bold text-4xl text-institutional-dark leading-tight text-center animate-fade-in-up">
        ✏️ Editar Configuración
    </h1>
@endsection

@section('content')
    <div class="container-custom py-8 animate-fade-in">

        {{-- Mensajes de feedback --}}
        @if (session('success'))
            <div class="p-4 mb-6 rounded-lg shadow-md animate-fade-in bg-success-light text-success" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-6 rounded-lg shadow-md animate-fade-in bg-danger-light text-danger" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Formulario principal --}}
        <form method="POST" action="{{ route('admin.configuraciones.update', $configuracion) }}"
            class="space-y-6 bg-white p-6 md:p-8 rounded-2xl shadow-soft-lg">
            @csrf
            @method('PUT')

            {{-- Campo Clave (solo lectura) --}}
            <div>
                <label for="clave" class="block font-semibold text-sm text-institutional mb-1">Clave</label>
                <input type="text" id="clave" value="{{ $configuracion->clave }}" disabled
                    class="w-full border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-steel cursor-not-allowed focus:outline-none"
                    aria-disabled="true" />
                <p class="text-gray-500 text-xs mt-1">Identificador único de la configuración (no editable).</p>
            </div>

            {{-- Campo Valor --}}
            <div>
                <label for="valor" class="block font-semibold text-sm text-institutional mb-1">Valor</label>
                <input type="text" name="valor" id="valor" value="{{ old('valor', $configuracion->valor) }}"
                    required
                    class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 transition duration-400 focus:ring-gold-dark focus:border-gold-dark @error('valor') border-danger focus:ring-danger @enderror"
                    aria-describedby="valor-error" aria-invalid="@error('valor') true @else false @enderror" />
                @error('valor')
                    <p id="valor-error" role="alert" class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Ingrese el valor que tendrá la configuración.</p>
            </div>

            {{-- Campo Descripción --}}
            <div>
                <label for="descripcion" class="block font-semibold text-sm text-institutional mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 transition duration-400 focus:ring-gold-dark focus:border-gold-dark @error('descripcion') border-danger focus:ring-danger @enderror"
                    aria-describedby="descripcion-error" aria-invalid="@error('descripcion') true @else false @enderror">{{ old('descripcion', $configuracion->descripcion) }}</textarea>
                @error('descripcion')
                    <p id="descripcion-error" role="alert" class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Explique brevemente el propósito de esta configuración.</p>
            </div>

            {{-- Botones de acción --}}
            <div class="flex flex-wrap gap-3 justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="btn-primary" title="Guardar cambios">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('admin.configuraciones.index') }}" class="btn-secondary" title="Cancelar">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection

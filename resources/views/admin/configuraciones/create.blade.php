@extends('layouts.app')

@section('header')
    <h1 class="font-display font-bold text-4xl text-institutional-dark leading-tight text-center animate-fade-in-up">
        ✨ Nueva Configuración
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

        {{-- Formulario --}}
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-soft-lg space-y-6">
            <p class="text-steel text-center mb-4 font-merriweather">
                Crea una nueva clave de configuración para personalizar el sistema.
            </p>

            <form method="POST" action="{{ route('admin.configuraciones.store') }}" class="space-y-6">
                @csrf

                {{-- Campo Clave --}}
                <div>
                    <label for="clave" class="block font-semibold text-sm text-institutional mb-1">Clave</label>
                    <input type="text" name="clave" id="clave" value="{{ old('clave') }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400 @error('clave') border-danger @enderror"
                        placeholder="Ejemplo: tamanio_maximo_archivo" autocomplete="off" />
                    @error('clave')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Clave única para identificar la configuración (sin espacios).</p>
                </div>

                {{-- Campo Valor --}}
                <div>
                    <label for="valor" class="block font-semibold text-sm text-institutional mb-1">Valor</label>
                    <input type="text" name="valor" id="valor" value="{{ old('valor') }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400 @error('valor') border-danger @enderror"
                        placeholder="Ejemplo: 5242880" autocomplete="off" />
                    @error('valor')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Valor numérico o de texto asignado a la configuración.</p>
                </div>

                {{-- Campo Descripción --}}
                <div>
                    <label for="descripcion" class="block font-semibold text-sm text-institutional mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-gold-dark focus:border-gold-dark transition duration-400 @error('descripcion') border-danger @enderror"
                        placeholder="Descripción breve sobre la configuración">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones de acción --}}
                <div class="flex flex-wrap justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn-primary" title="Crear configuración">
                        <i class="fas fa-save"></i> Crear
                    </button>
                    <a href="{{ route('admin.configuraciones.index') }}" class="btn-secondary" title="Cancelar">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

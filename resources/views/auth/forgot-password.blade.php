<x-guest-layout>
    {{-- Contenedor del mensaje principal --}}
    <div class="mb-4 text-sm text-dim-white/80 font-sans leading-relaxed">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecerla.') }}
    </div>

    <x-auth-session-status class="mb-4 text-sm font-medium text-success" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" data-parsley-validate>
        @csrf

        {{-- Campo de dirección de correo electrónico --}}
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gold" />
            <x-text-input id="email"
                class="block mt-1 w-full bg-glass-dark text-dim-white/90 border-institutional focus:border-gold focus:ring-gold"
                type="email" name="email" :value="old('email')" required autofocus data-parsley-type="email"
                data-parsley-required-message="Por favor, introduce tu correo electrónico." />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger animate-fade-in" />
        </div>

        {{-- Botón de envío --}}
        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="btn-primary animate-scale-in-center">
                {{ __('Enviar Enlace para Restablecer Contraseña') }}
            </button>
        </div>
    </form>
</x-guest-layout>

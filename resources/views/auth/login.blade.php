<x-guest-layout>
    {{-- Encabezado del formulario --}}
    <div class="text-center mb-8 animate-fade-in-down">
        {{-- Icono con brillo y color dorado --}}
        <i class="fa-solid fa-lock text-gold-light text-4xl mb-3 animate-glow"></i>
        {{-- Título principal con gradiente animado y tipografía display --}}
        <h2 class="text-4xl font-display font-bold text-gradient-animated mb-2">
            Acceso al Sistema
        </h2>
        {{-- Subtítulo con color steel-light --}}
        <p class="text-lg font-light text-steel-light">
            Utiliza tu correo y contraseña institucionales.
        </p>
    </div>

    {{-- Estado de sesión --}}
    {{-- Se usa un color más suave para el estado de sesión --}}
    <x-auth-session-status class="mb-6 text-base font-medium text-success animate-fade-in" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        {{-- Campo: correo electrónico --}}
        <div class="animate-slide-up-fade group">
            <x-input-label for="email" :value="__('Correo Electrónico')"
                class="text-gold mb-2 text-base font-semibold transition-colors duration-200 group-hover:text-gold-light" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                class="block w-full p-4 rounded-lg glass-dark text-white placeholder-steel-light/70
                       border-2 border-steel-light/40 focus:border-gold focus:ring-gold transition-all duration-300
                       group-hover:ring-2 group-hover:ring-gold/60 group-hover:border-gold animate-pulse-border-input" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger animate-fade-in" />
        </div>

        {{-- Campo: contraseña --}}
        <div class="animate-slide-up-fade delay-100 group">
            <x-input-label for="password" :value="__('Contraseña')"
                class="text-gold mb-2 text-base font-semibold transition-colors duration-200 group-hover:text-gold-light" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                class="block w-full p-4 rounded-lg glass-dark text-white placeholder-steel-light/70
                       border-2 border-steel-light/40 focus:border-gold focus:ring-gold transition-all duration-300
                       group-hover:ring-2 group-hover:ring-gold/60 group-hover:border-gold animate-pulse-border-input" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger animate-fade-in" />
        </div>

        {{-- Recordarme --}}
        <div class="block pt-2 animate-slide-up-fade delay-200">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded-sm border-gray-500 bg-institutional-dark text-gold shadow-sm
                           focus:ring-gold focus:ring-offset-institutional-dark transition-all duration-200 transform scale-110">
                <span
                    class="ml-3 text-base text-steel-light group-hover:text-gold-light transition-colors duration-200">
                    {{ __('Recordarme') }}
                </span>
            </label>
        </div>

        {{-- Acciones --}}
        <div class="flex items-center justify-between mt-10 animate-slide-up-fade delay-300">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-base text-steel-light hover:text-gold-light hover:underline transition-colors duration-300 font-medium">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <button type="submit" class="btn-primary animate-scale-in-center shadow-gold-glow">
                {{ __('Acceder') }}
            </button>
        </div>
    </form>
</x-guest-layout>

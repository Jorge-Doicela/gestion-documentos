<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\LogSuccessfulLogin; // ¡Importa tu listener de Login!
use App\Listeners\LogSuccessfulLogout; // ¡Importa tu listener de Logout!

class EventServiceProvider extends ServiceProvider
{
    /**
     * Los mapeos de eventos a listeners para la aplicación.
     * Estos listeners reaccionarán cuando ocurran los eventos listados.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Login::class => [ // Cuando un usuario inicie sesión...
            LogSuccessfulLogin::class, // ...ejecuta este listener
        ],
        Logout::class => [ // Cuando un usuario cierre sesión...
            LogSuccessfulLogout::class, // ...ejecuta este listener
        ],
    ];

    /**
     * Registra cualquier evento para tu aplicación.
     */
    public function boot(): void
    {
        parent::boot();
        // Puedes añadir aquí cualquier otra lógica de inicialización si la necesitas.
    }

    /**
     * Determina si los eventos y listeners deben ser descubiertos automáticamente.
     * Para los eventos de autenticación, es buena práctica registrarlos explícitamente.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false; // Mantenlo en 'false' para asegurarte que tus registros explícitos funcionen sin interferencias.
    }
}

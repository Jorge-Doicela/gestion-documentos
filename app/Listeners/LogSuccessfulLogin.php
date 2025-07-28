<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\LogActividad; // Asegúrate de que este modelo exista en tu carpeta App/Models
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogin
{
    /**
     * Maneja el evento de inicio de sesión exitoso.
     */
    public function handle(Login $event): void
    {
        LogActividad::create([
            'user_id' => $event->user->id,
            'accion' => 'Login exitoso',
            'descripcion' => 'El usuario inició sesión correctamente',
            'ip' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}

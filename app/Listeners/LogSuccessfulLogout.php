<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\LogActividad; // Asegúrate de que este modelo exista en tu carpeta App/Models
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogout
{
    /**
     * Maneja el evento de cierre de sesión.
     */
    public function handle(Logout $event): void
    {
        // En el evento Logout, $event->user puede ser null si la sesión ya fue destruida
        // o si es un usuario invitado. Es importante verificar esto.
        $userId = $event->user ? $event->user->id : null;

        LogActividad::create([
            'user_id' => $userId,
            'accion' => 'Logout',
            'descripcion' => 'El usuario cerró sesión',
            'ip' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}

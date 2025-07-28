<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// Remove the 'use' statements for Event, Login, Logout, LogSuccessfulLogin, LogSuccessfulLogout
// unless you're using them elsewhere in bootstrap/app.php for other purposes.

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ... your middleware configuration ...
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'check.role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // ... your exception handling ...
    })
    // ->withEvents(...) <-- REMOVE THIS BLOCK
    ->create();

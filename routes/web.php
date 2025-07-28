<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TipoDocumentoController;
use App\Http\Controllers\Admin\ConfiguracionController;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Dashboard general (requiere login y verificación)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil de usuario (cualquier usuario autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Paneles según rol
Route::middleware(['role:Administrador General'])->group(function () {
    Route::get('/admin', [UserController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['role:Coordinador de Prácticas'])->group(function () {
    Route::get('/coordinador', [\App\Http\Controllers\Coordinador\CoordinadorController::class, 'index'])->name('coordinador.dashboard');
});

Route::middleware(['role:Tutor Académico'])->group(function () {
    Route::get('/tutor', [\App\Http\Controllers\TutorController::class, 'index'])->name('tutor.dashboard');
});

Route::middleware(['role:Estudiante'])->group(function () {
    Route::get('/estudiante', [\App\Http\Controllers\EstudianteController::class, 'index'])->name('estudiante.dashboard');
});

// CRUD de Usuarios y otros módulos - solo para Administrador General
Route::middleware(['auth', 'role:Administrador General'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('tipos-documento', TipoDocumentoController::class);
        Route::resource('configuraciones', ConfiguracionController::class)
            ->parameters(['configuraciones' => 'configuracion'])
            ->only(['index', 'edit', 'update']);
    });

// Rutas de autenticación Breeze
require __DIR__ . '/auth.php';

// Redirección general para /home
Route::get('/home', fn() => redirect()->route('dashboard'))->name('home');

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['role:Administrador General'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['role:Coordinador de Prácticas'])->group(function () {
    Route::get('/coordinador', [CoordinadorController::class, 'index'])->name('coordinador.dashboard');
});

Route::middleware(['role:Tutor Académico'])->group(function () {
    Route::get('/tutor', [TutorController::class, 'index'])->name('tutor.dashboard');
});

Route::middleware(['role:Estudiante'])->group(function () {
    Route::get('/estudiante', [EstudianteController::class, 'index'])->name('estudiante.dashboard');
});

require __DIR__ . '/auth.php';

Route::get('/home', fn() => redirect()->route('dashboard'))->name('home');

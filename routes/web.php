<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TipoDocumentoController;
use App\Http\Controllers\Admin\ConfiguracionController;
use App\Http\Controllers\Admin\NormativaDocumentoController;
use App\Http\Controllers\NormativaPublicController;
use App\Http\Controllers\Admin\LogActividadController;
use App\Http\Controllers\Tutor\DashboardController;
use App\Http\Controllers\Tutor\TutorEstudianteController;
use App\Http\Controllers\Coordinador\CoordinadorController;
use App\Http\Controllers\Estudiante\DocumentoController;
use App\Http\Controllers\Tutor\RevisionDocumentosController;
use App\Http\Controllers\Tutor\RevisionHistorialController;
use App\Http\Controllers\Coordinador\CoordinadorDocumentoController;
use App\Http\Controllers\Coordinador\CertificadoController as CoordinadorCertificadoController;
use App\Http\Controllers\Estudiante\CertificadoController as EstudianteCertificadoController;

// ---------------------------------------------
// Página de bienvenida
// ---------------------------------------------
Route::get('/', fn() => view('welcome'));

// ---------------------------------------------
// Dashboard general
// ---------------------------------------------
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ---------------------------------------------
// Perfil de usuario (todos los roles)
// ---------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------------------------------
// Panel Administrador General
// ---------------------------------------------
Route::middleware(['auth', 'role:Administrador General'])->group(function () {
    Route::get('/admin', [UserController::class, 'index'])->name('admin.dashboard');
});

// ---------------------------------------------
// Panel Coordinador de Prácticas
// ---------------------------------------------
Route::prefix('coordinador')
    ->middleware(['auth', 'role:Coordinador de Prácticas'])
    ->name('coordinador.')
    ->group(function () {
        Route::get('/', [CoordinadorController::class, 'index'])->name('dashboard');

        // Revisión de documentos aprobados por tutor
        Route::get('/documentos-aprobados', [CoordinadorDocumentoController::class, 'index'])->name('documentos.aprobados');
        Route::put('/documentos-aprobados/{documento}', [CoordinadorDocumentoController::class, 'update'])->name('documentos.update');

        // Generar certificado oficial PDF
        Route::post('/certificados/generar/{user}', [CoordinadorCertificadoController::class, 'generar'])->name('certificados.generar');
    });

// ---------------------------------------------
// Rutas Tutor Académico
// ---------------------------------------------
Route::prefix('tutor')
    ->middleware(['auth', 'role:Tutor Académico'])
    ->name('tutor.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Gestión de estudiantes asignados
        Route::get('/estudiantes', [TutorEstudianteController::class, 'index'])->name('estudiantes.index');
        Route::get('/estudiantes/{id}', [TutorEstudianteController::class, 'show'])->name('estudiantes.show');

        // Revisión de documentos
        Route::prefix('revision-documentos')->name('revision.')->group(function () {
            Route::get('/', [RevisionDocumentosController::class, 'index'])->name('index');
            Route::get('/{documento}', [RevisionDocumentosController::class, 'show'])->name('show');
            Route::get('/{documento}/ver', [RevisionDocumentosController::class, 'verDocumento'])->name('ver');
            Route::post('/{documento}/comentarios', [RevisionDocumentosController::class, 'guardarComentarios'])->name('comentarios');
            Route::post('/{documento}/aprobar', [RevisionDocumentosController::class, 'aprobar'])->name('aprobar');
            Route::post('/{documento}/rechazar', [RevisionDocumentosController::class, 'rechazar'])->name('rechazar');
        });

        // Historial de revisión de documentos
        Route::get('/historial-revision', [RevisionHistorialController::class, 'index'])->name('historial.index');
    });

// ---------------------------------------------
// Rutas Estudiante
// ---------------------------------------------
Route::prefix('estudiante')
    ->middleware(['auth', 'role:Estudiante'])
    ->name('estudiante.')
    ->group(function () {
        Route::view('/', 'dashboard')->name('dashboard');

        // Gestión de documentos
        Route::prefix('documentos')->name('documentos.')->group(function () {
            Route::get('/', [DocumentoController::class, 'index'])->name('index');
            Route::get('/create/{tipoDocumento}', [DocumentoController::class, 'create'])->name('create');
            Route::post('/store', [DocumentoController::class, 'store'])->name('store');
            Route::get('/edit/{documento}', [DocumentoController::class, 'edit'])->name('edit');
            Route::put('/update/{documento}', [DocumentoController::class, 'update'])->name('update');
            Route::get('/show/{documento}', [DocumentoController::class, 'show'])->name('show');
            Route::delete('/{documento}', [DocumentoController::class, 'destroy'])->name('destroy');

            // Ver y descargar PDFs
            Route::get('/{documento}/view', [DocumentoController::class, 'view'])->name('view');
            Route::get('/{documento}/download', [DocumentoController::class, 'download'])->name('download');
        });

        // Descargar certificado PDF
        Route::get('certificados/descargar/{uuid}', [EstudianteCertificadoController::class, 'descargar'])->name('certificados.descargar');
    });

// ---------------------------------------------
// Rutas Admin (Administrador General + Coordinador)
// ---------------------------------------------
Route::prefix('admin')
    ->middleware(['auth', 'role:Administrador General|Coordinador de Prácticas'])
    ->name('admin.')
    ->group(function () {
        // CRUD usuarios
        Route::resource('users', UserController::class);

        // CRUD tipos de documentos
        Route::resource('tipos-documento', TipoDocumentoController::class);
        Route::get('tipos-documento/{tipo}/download', [TipoDocumentoController::class, 'download'])->name('tipos-documento.download');
        Route::get('tipos-documento/{tipo}/view', [TipoDocumentoController::class, 'view'])->name('tipos-documento.view');

        // Configuraciones
        Route::prefix('configuraciones')->name('configuraciones.')->group(function () {
            Route::get('/', [ConfiguracionController::class, 'index'])->name('index');
            Route::get('/create', [ConfiguracionController::class, 'create'])->name('create');
            Route::post('/', [ConfiguracionController::class, 'store'])->name('store');
            Route::get('/{configuracion}/edit', [ConfiguracionController::class, 'edit'])->name('edit');
            Route::put('/{configuracion}', [ConfiguracionController::class, 'update'])->name('update');
            Route::delete('/{configuracion}', [ConfiguracionController::class, 'destroy'])->name('destroy');
        });

        // CRUD normativas
        Route::resource('normativas', NormativaDocumentoController::class);

        // Logs de actividad
        Route::get('logs-actividad', [LogActividadController::class, 'index'])->name('logs_actividad.index');
        Route::get('logs', [LogActividadController::class, 'index'])->name('logs.index');
    });

// ---------------------------------------------
// Rutas públicas de normativas
// ---------------------------------------------
Route::get('/normativas', [NormativaPublicController::class, 'index'])->name('normativas.index');

// ---------------------------------------------
// Autenticación Breeze
// ---------------------------------------------
require __DIR__ . '/auth.php';

// Redirección /home
Route::get('/home', fn() => redirect()->route('dashboard'))->name('home');

<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\LogActividad;
use Illuminate\Support\Facades\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tutor = auth()->user();
        $estudiantes = $tutor->estudiantesAsignados()->paginate(10);

        // Registro de log de auditoría
        LogActividad::create([
            'user_id' => $tutor->id,
            'accion' => 'Acceso a Dashboard Tutor',
            'descripcion' => "Tutor {$tutor->name} accedió a su dashboard con " . $estudiantes->total() . " estudiantes asignados.",
            'ip' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);

        return view('tutor.dashboard', compact('estudiantes'));
    }
}

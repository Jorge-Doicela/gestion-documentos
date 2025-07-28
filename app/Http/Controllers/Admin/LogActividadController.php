<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogActividad;
use Illuminate\Http\Request;

class LogActividadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador General']);
    }

    public function index(Request $request)
    {
        $query = LogActividad::with('user')->orderByDesc('created_at');

        // Filtros opcionales
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('accion')) {
            $query->where('accion', 'like', '%' . $request->accion . '%');
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $logs = $query->paginate(20)->withQueryString();

        // Para llenar filtros
        $usuarios = \App\Models\User::orderBy('name')->get();

        return view('admin.logs.index', compact('logs', 'usuarios'));
    }
}

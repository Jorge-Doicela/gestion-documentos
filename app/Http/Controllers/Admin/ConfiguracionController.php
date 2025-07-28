<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuraciones = Configuracion::orderBy('clave')->get();
        return view('admin.configuraciones.index', compact('configuraciones'));
    }

    public function edit(Configuracion $configuracion)
    {
        return view('admin.configuraciones.edit', compact('configuracion'));
    }

    public function update(Request $request, Configuracion $configuracion)
    {
        $request->validate([
            'valor' => 'required|string|max:1000',
        ]);

        $configuracion->update([
            'valor' => $request->valor,
        ]);

        return redirect()->route('admin.configuraciones.index')->with('success', 'Configuración actualizada correctamente.');
    }
}

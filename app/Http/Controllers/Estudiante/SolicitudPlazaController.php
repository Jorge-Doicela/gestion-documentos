<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolicitudPlaza;
use App\Models\Plaza;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SolicitudPlazaController extends Controller
{
    // Mostrar formulario para postular
    public function create($plaza_id)
    {
        $plaza = Plaza::findOrFail($plaza_id);
        return view('estudiante.solicitud.create', compact('plaza'));
    }

    // Guardar solicitud de plaza
    public function store(Request $request, $plaza_id)
    {
        $request->validate([
            'cv' => 'nullable|mimes:pdf|max:5120',
            'documentos.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $cv_ruta = $request->hasFile('cv') ? $request->file('cv')->store('cvs', 'public') : null;

        $documentos_json = [];
        if ($request->hasFile('documentos')) {
            foreach ($request->file('documentos') as $doc) {
                $documentos_json[] = $doc->store('documentos_pre', 'public');
            }
        }

        SolicitudPlaza::create([
            'estudiante_id' => Auth::id(),
            'plaza_id' => $plaza_id,
            'cv_ruta' => $cv_ruta,
            'documentos_json' => json_encode($documentos_json),
        ]);

        return redirect()->route('plazas.disponibles')->with('success', 'Solicitud enviada correctamente.');
    }
}

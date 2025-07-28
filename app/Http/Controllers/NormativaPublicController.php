<?php

namespace App\Http\Controllers;

use App\Models\NormativaDocumento;

class NormativaPublicController extends Controller
{
    // Mostrar listado de normativas visibles para estudiantes
    public function index()
    {
        $normativas = NormativaDocumento::with('tipoDocumento')->paginate(10);

        return view('normativas.index', compact('normativas'));
    }
}

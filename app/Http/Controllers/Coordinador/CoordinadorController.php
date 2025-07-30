<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoordinadorController extends Controller
{
    public function index()
    {
        return view('dashboard'); // Crea esta vista luego
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        if ($user->hasRole('Administrador General')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Coordinador de Prácticas')) {
            return redirect()->route('coordinador.dashboard');
        } elseif ($user->hasRole('Tutor Académico')) {
            return redirect()->route('tutor.dashboard');
        } elseif ($user->hasRole('Estudiante')) {
            return redirect()->route('estudiante.dashboard');
        }

        // Fallback
        return redirect()->route('home');
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

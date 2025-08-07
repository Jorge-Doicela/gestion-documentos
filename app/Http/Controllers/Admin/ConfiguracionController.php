<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use App\Models\LogActividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadeRequest;

class ConfiguracionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Administrador General|Coordinador de Prácticas');
    }

    public function index(Request $request)
    {
        $query = Configuracion::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('clave', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
        }

        $configuraciones = $query->orderBy('clave')->paginate(10)->withQueryString();

        return view('admin.configuraciones.index', compact('configuraciones'));
    }

    public function create()
    {
        return view('admin.configuraciones.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'clave' => 'required|string|max:255|unique:configuraciones,clave',
            'valor' => 'required|string|max:1000',
            'descripcion' => 'nullable|string|max:1000',
        ];

        if ($request->clave === 'tamanio_maximo_archivo') {
            $rules['valor'] = 'required|integer|min:1024|max:104857600';
        }

        if ($request->clave === 'estados_documento') {
            $rules['valor'] = ['required', 'string', function ($attribute, $value, $fail) {
                $decoded = json_decode($value);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                    $fail('El campo estados_documento debe ser un JSON válido de arreglo.');
                }
            }];
        }

        $validated = $request->validate($rules);

        $config = Configuracion::create($validated);

        // Log de creación
        LogActividad::create([
            'user_id' => auth()->id(),
            'accion' => 'Configuración creada',
            'descripcion' => "Clave: {$config->clave}, Valor: {$config->valor}",
            'ip' => FacadeRequest::ip(),
            'user_agent' => FacadeRequest::userAgent(),
        ]);

        return redirect()->route('admin.configuraciones.index')
            ->with('success', 'Configuración creada correctamente.');
    }

    public function edit(Configuracion $configuracion)
    {
        return view('admin.configuraciones.edit', compact('configuracion'));
    }

    public function update(Request $request, Configuracion $configuracion)
    {
        $rules = [
            'valor' => 'required|string|max:1000',
            'descripcion' => 'nullable|string|max:1000',
        ];

        if ($configuracion->clave === 'tamanio_maximo_archivo') {
            $rules['valor'] = 'required|integer|min:1024|max:104857600';
        }

        if ($configuracion->clave === 'estados_documento') {
            $rules['valor'] = ['required', 'string', function ($attribute, $value, $fail) {
                $decoded = json_decode($value);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                    $fail('El campo estados_documento debe ser un JSON válido de arreglo.');
                }
            }];
        }

        $validated = $request->validate($rules);

        $configuracion->update([
            'valor' => $validated['valor'],
            'descripcion' => $request->descripcion ?? $configuracion->descripcion,
        ]);

        // Log de actualización
        LogActividad::create([
            'user_id' => auth()->id(),
            'accion' => 'Configuración actualizada',
            'descripcion' => "Clave: {$configuracion->clave}, Nuevo valor: {$validated['valor']}",
            'ip' => FacadeRequest::ip(),
            'user_agent' => FacadeRequest::userAgent(),
        ]);

        return redirect()->route('admin.configuraciones.index')
            ->with('success', 'Configuración actualizada correctamente.');
    }

    public function destroy(Configuracion $configuracion)
    {
        $clave = $configuracion->clave;
        $valor = $configuracion->valor;

        $configuracion->delete();

        // Log de eliminación
        LogActividad::create([
            'user_id' => auth()->id(),
            'accion' => 'Configuración eliminada',
            'descripcion' => "Clave: {$clave}, Valor eliminado: {$valor}",
            'ip' => FacadeRequest::ip(),
            'user_agent' => FacadeRequest::userAgent(),
        ]);

        return redirect()->route('admin.configuraciones.index')
            ->with('success', 'Configuración eliminada correctamente.');
    }
}

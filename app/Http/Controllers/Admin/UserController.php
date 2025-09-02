<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Carrera;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use PDF;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles', 'carrera', 'tutor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        if ($request->filled('carrera_id')) {
            $query->where('carrera_id', $request->carrera_id);
        }

        if ($request->filled('tutor_id')) {
            $query->where('tutor_id', $request->tutor_id);
        }

        $users = $query->paginate(15)->withQueryString();

        $rolesOrdenados = [
            'Administrador General',
            'Coordinador de Prácticas',
            'Tutor Académico',
            'Estudiante',
        ];

        $rolesEnBD = Role::pluck('name')->toArray();
        $roles = collect($rolesOrdenados)->filter(fn($rol) => in_array($rol, $rolesEnBD));

        $carreras = Carrera::pluck('nombre', 'id');
        $tutores = User::role('Tutor Académico')->pluck('name', 'id');

        return view('admin.users.index', compact('users', 'roles', 'carreras', 'tutores'));
    }

    public function create()
    {
        $rolesOrdenados = [
            'Administrador General',
            'Coordinador de Prácticas',
            'Tutor Académico',
            'Estudiante',
        ];

        $rolesEnBD = Role::pluck('name')->toArray();
        $roles = collect($rolesOrdenados)->filter(fn($rol) => in_array($rol, $rolesEnBD));

        $carreras = Carrera::pluck('nombre', 'id');
        $tutores = User::role('Tutor Académico')->pluck('name', 'id');

        return view('admin.users.create', compact('roles', 'carreras', 'tutores'));
    }

    public function store(Request $request)
    {
        // Convertir campos vacíos a null
        $request->merge([
            'carrera_id' => $request->carrera_id ?: null,
            'tutor_id' => $request->tutor_id ?: null,
        ]);

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:8|confirmed',
            'role'             => 'required|exists:roles,name',
            'telefono'         => ['nullable', 'string', 'regex:/^\+?[0-9\s\-]{7,15}$/'],
            'direccion'        => 'nullable|string|max:255',
            'identificacion'   => 'nullable|string|unique:users,identificacion',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'genero'           => 'nullable|in:Masculino,Femenino,Otro',
            'carrera_id'       => 'nullable|exists:carreras,id',
            'tutor_id'         => 'nullable|exists:users,id',
        ]);

        $user = User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'telefono'         => $request->telefono,
            'direccion'        => $request->direccion,
            'identificacion'   => $request->identificacion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero'           => $request->genero,
            'carrera_id'       => $request->carrera_id,
            'tutor_id'         => $request->tutor_id,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $rolesOrdenados = [
            'Administrador General',
            'Coordinador de Prácticas',
            'Tutor Académico',
            'Estudiante',
        ];

        $rolesEnBD = Role::pluck('name')->toArray();
        $roles = collect($rolesOrdenados)->filter(fn($rol) => in_array($rol, $rolesEnBD));

        $carreras = Carrera::pluck('nombre', 'id');
        $tutores = User::role('Tutor Académico')->pluck('name', 'id');

        return view('admin.users.edit', compact('user', 'roles', 'carreras', 'tutores'));
    }

    public function update(Request $request, User $user)
    {
        // Convertir campos vacíos a null
        $request->merge([
            'carrera_id' => $request->carrera_id ?: null,
            'tutor_id' => $request->tutor_id ?: null,
        ]);

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'         => 'nullable|string|min:8|confirmed',
            'role'             => 'required|exists:roles,name',
            'telefono'         => ['nullable', 'string', 'regex:/^\+?[0-9\s\-]{7,15}$/'],
            'direccion'        => 'nullable|string|max:255',
            'identificacion'   => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'fecha_nacimiento' => 'nullable|date|before:today',
            'genero'           => 'nullable|in:Masculino,Femenino,Otro',
            'carrera_id'       => 'nullable|exists:carreras,id',
            'tutor_id'         => 'nullable|exists:users,id',
        ]);

        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->telefono         = $request->telefono;
        $user->direccion        = $request->direccion;
        $user->identificacion   = $request->identificacion;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->genero           = $request->genero;
        $user->carrera_id       = $request->carrera_id;
        $user->tutor_id         = $request->tutor_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $user->syncRoles($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['search', 'role', 'carrera_id', 'tutor_id']);
        return Excel::download(new UsersExport($filters), 'usuarios.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $query = User::with(['roles', 'carrera', 'tutor']);

        if ($request->filled('search')) {
            $query->where(fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"));
        }
        if ($request->filled('role')) $query->role($request->role);
        if ($request->filled('carrera_id')) $query->where('carrera_id', $request->carrera_id);
        if ($request->filled('tutor_id')) $query->where('tutor_id', $request->tutor_id);

        $users = $query->get();

        $pdf = PDF::loadView('admin.users.pdf', compact('users'));
        return $pdf->download('usuarios.pdf');
    }
}

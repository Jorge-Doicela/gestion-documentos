<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'carrera', 'tutor')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name');
        // Para select de carreras y tutores (si aplica)
        $carreras = \App\Models\Carrera::pluck('nombre', 'id');
        $tutores = User::role('Tutor Académico')->pluck('name', 'id'); // CAMBIO AQUÍ

        return view('admin.users.create', compact('roles', 'carreras', 'tutores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|string|min:8|confirmed',
            'role'           => 'required|exists:roles,name',
            'telefono'       => ['nullable', 'string', 'regex:/^\+?[0-9\s\-]{7,15}$/'],
            'direccion'      => 'nullable|string|max:255',
            'identificacion' => 'nullable|string|unique:users,identificacion',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'genero'         => 'nullable|in:Masculino,Femenino,Otro',
            'carrera_id'     => 'nullable|exists:carreras,id',
            'tutor_id'       => 'nullable|exists:users,id',
        ]);

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'telefono'       => $request->telefono,
            'direccion'      => $request->direccion,
            'identificacion' => $request->identificacion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero'         => $request->genero,
            'carrera_id'     => $request->carrera_id,
            'tutor_id'       => $request->tutor_id,
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
        $roles = Role::pluck('name', 'name');
        $carreras = \App\Models\Carrera::pluck('nombre', 'id');
        $tutores = User::role('Tutor Académico')->pluck('name', 'id'); // CAMBIO AQUÍ

        return view('admin.users.edit', compact('user', 'roles', 'carreras', 'tutores'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'       => 'nullable|string|min:8|confirmed',
            'role'           => 'required|exists:roles,name',
            'telefono'       => ['nullable', 'string', 'regex:/^\+?[0-9\s\-]{7,15}$/'],
            'direccion'      => 'nullable|string|max:255',
            'identificacion' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'fecha_nacimiento' => 'nullable|date|before:today',
            'genero'         => 'nullable|in:Masculino,Femenino,Otro',
            'carrera_id'     => 'nullable|exists:carreras,id',
            'tutor_id'       => 'nullable|exists:users,id',
        ]);

        $user->name           = $request->name;
        $user->email          = $request->email;
        $user->telefono       = $request->telefono;
        $user->direccion      = $request->direccion;
        $user->identificacion = $request->identificacion;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->genero         = $request->genero;
        $user->carrera_id     = $request->carrera_id;
        $user->tutor_id       = $request->tutor_id;

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
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario Administrador
        $admin = User::create([
            'name' => 'Admin General',
            'email' => 'admin@instituto.edu',
            'password' => Hash::make('password123'), // Cambiar por algo seguro
        ]);
        $admin->assignRole('Administrador');

        // Crear usuario Coordinador
        $coordinador = User::create([
            'name' => 'Coordinador de Prácticas',
            'email' => 'coordinador@instituto.edu',
            'password' => Hash::make('password123'),
        ]);
        $coordinador->assignRole('Coordinador');

        // Crear usuario Tutor
        $tutor = User::create([
            'name' => 'Tutor Académico',
            'email' => 'tutor@instituto.edu',
            'password' => Hash::make('password123'),
        ]);
        $tutor->assignRole('Tutor');

        // Crear usuario Estudiante
        $estudiante = User::create([
            'name' => 'Estudiante Ejemplo',
            'email' => 'estudiante@instituto.edu',
            'password' => Hash::make('password123'),
        ]);
        $estudiante->assignRole('Estudiante');
    }
}

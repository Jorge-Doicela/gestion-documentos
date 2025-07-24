<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario Administrador General
        $admin = User::create([
            'name' => 'Admin General',
            'email' => 'admin@instituto.edu',
            'password' => Hash::make('password123'), // Cambiar por contraseña segura
        ]);
        $admin->assignRole('Administrador General');

        // Crear usuario Coordinador de Prácticas
        $coordinador = User::create([
            'name' => 'Coordinador de Prácticas',
            'email' => 'coordinador@instituto.edu',
            'password' => Hash::make('password123'),
        ]);
        $coordinador->assignRole('Coordinador de Prácticas');

        // Crear usuario Tutor Académico
        $tutor = User::create([
            'name' => 'Tutor Académico',
            'email' => 'tutor@instituto.edu',
            'password' => Hash::make('password123'),
        ]);
        $tutor->assignRole('Tutor Académico');

        // Crear usuario Estudiante
        $estudiante = User::create([
            'name' => 'Estudiante Ejemplo',
            'email' => 'estudiante@instituto.edu',
            'password' => Hash::make('password123'),
        ]);
        $estudiante->assignRole('Estudiante');
    }
}

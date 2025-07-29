<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // ADMINISTRADOR GENERAL
        $admin = User::create([
            'name' => 'Administrador General',
            'email' => 'admin@instituto.edu',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('Administrador General');

        // COORDINADOR DE PRÁCTICAS
        $coordinador = User::create([
            'name' => 'Coordinador de Prácticas',
            'email' => 'coordinador@instituto.edu',
            'password' => Hash::make('password123'),
        ]);
        $coordinador->assignRole('Coordinador de Prácticas');

        // TUTOR ACADÉMICO
        $tutor = User::create([
            'name' => 'Tutor Académico',
            'email' => 'tutor@instituto.edu',
            'password' => Hash::make('password123'),
        ]);
        $tutor->assignRole('Tutor Académico');

        // ESTUDIANTES ASIGNADOS AL TUTOR
        $estudiantes = [
            [
                'name' => 'Estudiante Uno',
                'email' => 'estudiante1@instituto.edu',
            ],
            [
                'name' => 'Estudiante Dos',
                'email' => 'estudiante2@instituto.edu',
            ],
            [
                'name' => 'Estudiante Tres',
                'email' => 'estudiante3@instituto.edu',
            ],
        ];

        foreach ($estudiantes as $datos) {
            $estudiante = User::create([
                'name' => $datos['name'],
                'email' => $datos['email'],
                'password' => Hash::make('password123'),
                'tutor_id' => $tutor->id, // Relación con el tutor
            ]);
            $estudiante->assignRole('Estudiante');
        }
    }
}

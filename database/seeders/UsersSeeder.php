<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Admin General
        $admin = User::updateOrCreate(
            ['email' => 'admin@inst.edu'],
            [
                'name' => 'Admin General',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole('Administrador General');

        // Coordinador
        $coord = User::updateOrCreate(
            ['email' => 'coord@inst.edu'],
            [
                'name' => 'Coordinador de Prácticas',
                'password' => Hash::make('password123'),
            ]
        );
        $coord->assignRole('Coordinador de Prácticas');

        // Tutor 1
        $tutor1 = User::updateOrCreate(
            ['email' => 'tutor1@inst.edu'],
            [
                'name' => 'Tutor Uno',
                'password' => Hash::make('password123'),
            ]
        );
        $tutor1->assignRole('Tutor Académico');

        // Tutor 2
        $tutor2 = User::updateOrCreate(
            ['email' => 'tutor2@inst.edu'],
            [
                'name' => 'Tutor Dos',
                'password' => Hash::make('password123'),
            ]
        );
        $tutor2->assignRole('Tutor Académico');

        // Estudiantes asignados a tutor1
        $est1 = User::updateOrCreate(
            ['email' => 'est1@inst.edu'],
            [
                'name' => 'Estudiante Uno',
                'password' => Hash::make('password123'),
                'tutor_id' => $tutor1->id,
            ]
        );
        $est1->assignRole('Estudiante');

        $est2 = User::updateOrCreate(
            ['email' => 'est2@inst.edu'],
            [
                'name' => 'Estudiante Dos',
                'password' => Hash::make('password123'),
                'tutor_id' => $tutor1->id,
            ]
        );
        $est2->assignRole('Estudiante');

        // Estudiantes asignados a tutor2
        $est3 = User::updateOrCreate(
            ['email' => 'est3@inst.edu'],
            [
                'name' => 'Estudiante Tres',
                'password' => Hash::make('password123'),
                'tutor_id' => $tutor2->id,
            ]
        );
        $est3->assignRole('Estudiante');

        $est4 = User::updateOrCreate(
            ['email' => 'est4@inst.edu'],
            [
                'name' => 'Estudiante Cuatro',
                'password' => Hash::make('password123'),
                'tutor_id' => $tutor2->id,
            ]
        );
        $est4->assignRole('Estudiante');
    }
}

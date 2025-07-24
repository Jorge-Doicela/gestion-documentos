<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Limpiar cache de permisos y roles
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            'manage users',
            'manage documents',
            'review documents',
            'generate certificates',
            'view reports',
            'manage normatives',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'Administrador General']);
        $coordinator = Role::firstOrCreate(['name' => 'Coordinador de Prácticas']);
        $tutor = Role::firstOrCreate(['name' => 'Tutor Académico']);
        $student = Role::firstOrCreate(['name' => 'Estudiante']);

        // Asignar permisos a roles
        $admin->givePermissionTo(Permission::all());

        $coordinator->givePermissionTo([
            'review documents',
            'generate certificates',
            'view reports',
            'manage normatives',
        ]);

        $tutor->givePermissionTo([
            'review documents',
        ]);

        // El estudiante no recibe permisos administrativos
    }
}

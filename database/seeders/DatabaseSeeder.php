<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
            ConfiguracionesSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrera;

class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            ['nombre' => 'Ingeniería en Sistemas', 'descripcion' => 'Carrera de Ingeniería en Sistemas'],
            ['nombre' => 'Administración de Empresas', 'descripcion' => 'Carrera de Administración'],
            ['nombre' => 'Contabilidad', 'descripcion' => 'Carrera de Contabilidad y Finanzas'],
            // agrega más según instituto
        ];

        foreach ($carreras as $carrera) {
            Carrera::updateOrCreate(['nombre' => $carrera['nombre']], $carrera);
        }
    }
}

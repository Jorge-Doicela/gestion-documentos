<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TiposDocumentoSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            ['nombre' => 'Carta de aceptación', 'obligatorio' => true, 'orden' => 1],
            ['nombre' => 'Informe final', 'obligatorio' => true, 'orden' => 2],
            ['nombre' => 'Evaluación del tutor', 'obligatorio' => true, 'orden' => 3],
            ['nombre' => 'Formato de asistencia', 'obligatorio' => false, 'orden' => 4],
            ['nombre' => 'Certificado de prácticas', 'obligatorio' => false, 'orden' => 5],
        ];

        foreach ($tipos as $tipo) {
            TipoDocumento::updateOrCreate(['nombre' => $tipo['nombre']], $tipo);
        }
    }
}

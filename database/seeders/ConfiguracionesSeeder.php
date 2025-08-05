<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracion;

class ConfiguracionesSeeder extends Seeder
{
    public function run()
    {
        $configs = [
            ['clave' => 'tamanio_maximo_archivo', 'valor' => '5242880', 'descripcion' => 'Tamaño máximo en bytes (5MB)'],
            ['clave' => 'estados_documento', 'valor' => json_encode(['pendiente', 'no_aprobado', 'aprobado_tutor', 'aprobado_final']), 'descripcion' => 'Estados posibles del documento'],
        ];

        foreach ($configs as $conf) {
            Configuracion::updateOrCreate(['clave' => $conf['clave']], $conf);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NormativasDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('normativas_documentos')->insert([
            [
                'tipo_documento_id' => 1,
                'contenido' => 'Normativa para Informe Final: Debe tener portada, índice, introducción, etc.',
            ],
            [
                'tipo_documento_id' => 2,
                'contenido' => 'Normativa para Carta de Aceptación: Debe estar firmada y sellada por la empresa.',
            ],
            // Agrega más normativas según tus `tipos_documento`
        ]);
    }
}

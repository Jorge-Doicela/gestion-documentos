<?php
// database/seeders/ConfiguracionesSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracion;

class ConfiguracionesSeeder extends Seeder
{
    public function run()
    {
        Configuracion::updateOrCreate(
            ['clave' => 'max_file_size_mb'],
            ['valor' => '5', 'descripcion' => 'Tamaño máximo permitido para archivos en MB']
        );

        Configuracion::updateOrCreate(
            ['clave' => 'storage_base_path'],
            ['valor' => 'documentos/', 'descripcion' => 'Ruta base para guardar archivos de usuario']
        );
    }
}

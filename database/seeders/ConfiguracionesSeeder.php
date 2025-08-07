<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracion;

class ConfiguracionesSeeder extends Seeder
{
    public function run()
    {
        $configs = [
            // Tamaño máximo permitido para archivos en bytes (5MB)
            [
                'clave' => 'tamanio_maximo_archivo',
                'valor' => '5242880',
                'descripcion' => 'Tamaño máximo permitido para archivos subidos en bytes.'
            ],

            // Estados del flujo documental, como arreglo JSON
            [
                'clave' => 'estados_documento',
                'valor' => json_encode(['pendiente', 'no_aprobado', 'aprobado_tutor', 'aprobado_final']),
                'descripcion' => 'Estados posibles en el flujo de revisión documental.'
            ],

            // Tipos de archivo permitidos (extensiones)
            [
                'clave' => 'tipos_documento_permitidos',
                'valor' => json_encode(['pdf']),
                'descripcion' => 'Tipos de archivo permitidos para carga.'
            ],

            // Número máximo de documentos permitidos por estudiante
            [
                'clave' => 'numero_maximo_documentos',
                'valor' => '9',
                'descripcion' => 'Cantidad máxima de documentos que un estudiante puede subir por práctica.'
            ],

            // Extensiones válidas para carga (para validaciones)
            [
                'clave' => 'extensiones_archivo_validas',
                'valor' => json_encode(['pdf']),
                'descripcion' => 'Extensiones de archivo válidas para la carga de documentos.'
            ],

            // Duración máxima de sesión en minutos
            [
                'clave' => 'duracion_sesion_minutos',
                'valor' => '60',
                'descripcion' => 'Tiempo de expiración de sesión en minutos por inactividad.'
            ],

            // Intentos máximos fallidos de login antes de bloqueo temporal
            [
                'clave' => 'intentos_fallidos_maximos',
                'valor' => '5',
                'descripcion' => 'Número máximo de intentos de login fallidos antes de bloquear temporalmente.'
            ],

            // Tamaño máximo permitido para archivos en megabytes (para interfaces o cálculos)
            [
                'clave' => 'limite_tamano_archivo_mb',
                'valor' => '5',
                'descripcion' => 'Tamaño máximo permitido para archivos en megabytes (sin conversión a bytes).'
            ],

            // Ruta base para almacenamiento de documentos
            [
                'clave' => 'ruta_almacenamiento_documentos',
                'valor' => 'documentos/',
                'descripcion' => 'Ruta base para almacenar documentos cargados.'
            ],

            // Ruta base para almacenamiento de certificados
            [
                'clave' => 'ruta_almacenamiento_certificados',
                'valor' => 'certificados/',
                'descripcion' => 'Ruta base para almacenar certificados generados.'
            ],

            // Algoritmo usado para firma digital (hash)
            [
                'clave' => 'algoritmo_firma_digital',
                'valor' => 'SHA256',
                'descripcion' => 'Algoritmo utilizado para la firma digital de certificados.'
            ],

            // URL pública para verificar certificados por QR
            [
                'clave' => 'url_verificacion_certificado',
                'valor' => env('APP_URL') . '/certificado/verificar',
                'descripcion' => 'URL pública para verificación de certificados mediante QR.'
            ],

            // Habilitar o no notificaciones por correo electrónico (true/false)
            [
                'clave' => 'notificacion_email_habilitada',
                'valor' => 'true',
                'descripcion' => 'Indica si el sistema enviará notificaciones por correo electrónico.'
            ],

            // Página principal/redirección después del login por rol
            [
                'clave' => 'pagina_principal_estudiante',
                'valor' => '/estudiante/dashboard',
                'descripcion' => 'Ruta o URL para la página principal después de login para estudiantes.'
            ],
            [
                'clave' => 'pagina_principal_tutor',
                'valor' => '/tutor/dashboard',
                'descripcion' => 'Ruta o URL para la página principal después de login para tutores.'
            ],
            [
                'clave' => 'pagina_principal_coordinador',
                'valor' => '/coordinador/dashboard',
                'descripcion' => 'Ruta o URL para la página principal después de login para coordinadores.'
            ],
            [
                'clave' => 'pagina_principal_admin',
                'valor' => '/admin/dashboard',
                'descripcion' => 'Ruta o URL para la página principal después de login para administradores.'
            ],
        ];

        // Insertar o actualizar configuraciones en la base de datos
        foreach ($configs as $conf) {
            Configuracion::updateOrCreate(['clave' => $conf['clave']], $conf);
        }
    }
}

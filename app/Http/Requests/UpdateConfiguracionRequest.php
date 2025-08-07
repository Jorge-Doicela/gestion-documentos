<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConfiguracionRequest extends FormRequest
{
    public function authorize()
    {
        // Solo permitir a roles específicos editar configuración
        return $this->user()->hasAnyRole(['Administrador General', 'Coordinador de Prácticas']);
    }

    public function rules()
    {
        // Obtener el objeto Configuracion para validar según clave
        $configuracion = $this->route('configuracion');

        $rules = [
            'valor' => 'required|string|max:1000',
        ];

        if ($configuracion) {
            switch ($configuracion->clave) {
                case 'tamanio_maximo_archivo':
                    // Valor en bytes, mínimo 1KB, máximo 100MB
                    $rules['valor'] = 'required|integer|min:1024|max:104857600';
                    break;

                case 'estados_documento':
                    // Validar JSON que contenga un arreglo
                    $rules['valor'] = [
                        'required',
                        'string',
                        function ($attribute, $value, $fail) {
                            $decoded = json_decode($value);
                            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                                $fail('El campo estados_documento debe ser un JSON válido de arreglo.');
                            }
                        }
                    ];
                    break;

                    // Puedes añadir más reglas específicas según claves
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'valor.required' => 'El valor es obligatorio.',
            'valor.string' => 'El valor debe ser un texto.',
            'valor.integer' => 'El valor debe ser un número entero.',
            'valor.min' => 'El valor es demasiado pequeño.',
            'valor.max' => 'El valor es demasiado grande.',
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plaza extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'area_practica',
        'periodo_academico',
        'carrera',
        'habilidades_requeridas',
        'documentos_previos',
        'vacantes',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'documentos_previos' => 'array', // JSON a array automáticamente
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    // Relación: una plaza pertenece a una empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}

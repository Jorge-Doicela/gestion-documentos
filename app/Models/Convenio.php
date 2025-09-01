<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'descripcion',
        'ruta_pdf',
        'fecha_inicio',
        'fecha_fin',
        'firmado_por_instituto',
        'firmado_por_empresa',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    // Relación: un convenio pertenece a una empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}

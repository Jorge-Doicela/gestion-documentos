<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VersionDocumento extends Model
{
    use HasFactory;

    protected $table = 'versiones_documento';

    protected $fillable = [
        'documento_id',
        'numero_version',
        'ruta_archivo',
        'creado_por',
        'motivo_cambio',
    ];

    // Documento padre
    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }

    // Usuario que creó la versión
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}

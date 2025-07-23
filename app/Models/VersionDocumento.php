<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VersionDocumento extends Model
{
    protected $table = 'versiones_documento';

    protected $fillable = [
        'documento_id',
        'numero_version',
        'ruta_archivo',
        'creado_por',
        'motivo_cambio',
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NormativaDocumento extends Model
{
    protected $table = 'normativas_documentos';

    protected $fillable = [
        'tipo_documento_id',
        'contenido',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
}

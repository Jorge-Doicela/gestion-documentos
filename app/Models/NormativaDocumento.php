<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NormativaDocumento extends Model
{
    use HasFactory;

    protected $table = 'normativas_documentos';

    protected $fillable = [
        'tipo_documento_id',
        'contenido',
    ];

    // Tipo de documento asociado
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
}

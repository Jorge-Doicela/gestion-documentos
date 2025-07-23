<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documento';

    protected $fillable = ['nombre', 'descripcion', 'obligatorio', 'orden'];

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function normativas()
    {
        return $this->hasMany(NormativaDocumento::class, 'tipo_documento_id');
    }
}

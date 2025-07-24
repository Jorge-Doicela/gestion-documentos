<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $table = 'tipos_documento';

    protected $fillable = [
        'nombre',
        'descripcion',
        'obligatorio',
        'orden'
    ];

    protected $casts = [
        'obligatorio' => 'boolean',
    ];

    // Documentos asociados a este tipo
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    // Normativas asociadas a este tipo
    public function normativas()
    {
        return $this->hasMany(NormativaDocumento::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificado extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'ruta_pdf',
        'hash_verificacion',
        'firmado_por',
        'fecha_emision',
    ];

    protected $casts = [
        'fecha_emision' => 'datetime',
    ];

    // Usuario al que pertenece el certificado
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Usuario que firmó el certificado (coordinador)
    public function firmadoPor()
    {
        return $this->belongsTo(User::class, 'firmado_por');
    }
}

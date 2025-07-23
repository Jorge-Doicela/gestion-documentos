<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function firmante()
    {
        return $this->belongsTo(User::class, 'firmado_por');
    }
}

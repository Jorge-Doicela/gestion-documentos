<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento_id',
        'user_id',
        'seccion',
        'mensaje',
        'tipo',
    ];

    // Documento al que pertenece el comentario
    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }

    // Usuario que hizo el comentario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

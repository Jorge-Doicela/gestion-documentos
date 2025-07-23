<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'user_id',
        'tipo_documento_id',
        'nombre_archivo',
        'ruta_archivo',
        'estado',
        'comentarios_json',
        'fecha_revision',
    ];

    protected $casts = [
        'comentarios_json' => 'array',
        'fecha_revision' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    public function versiones()
    {
        return $this->hasMany(VersionDocumento::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}

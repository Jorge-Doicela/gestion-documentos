<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends Model
{
    use HasFactory;

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

    // Usuario propietario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Tipo de documento
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    // Versiones anteriores
    public function versiones()
    {
        return $this->hasMany(VersionDocumento::class, 'documento_id');
    }

    // Comentarios sobre el documento
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'documento_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

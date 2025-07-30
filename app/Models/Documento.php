<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends Model
{
    use HasFactory;

    // Opcional si la tabla se llama "documentos"
    protected $table = 'documentos';

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

    // Relación con usuario propietario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con tipo de documento
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    // Relación con versiones anteriores
    public function versiones()
    {
        return $this->hasMany(VersionDocumento::class, 'documento_id');
    }

    // Relación con comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'documento_id');
    }
}

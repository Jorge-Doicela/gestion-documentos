<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudPlaza extends Model
{
    use HasFactory;

    // Especificar la tabla
    protected $table = 'solicitudes_plaza';

    // Campos rellenables
    protected $fillable = [
        'estudiante_id',
        'plaza_id',
        'estado',
        'documentos'
    ];

    // Relación con estudiante
    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    // Relación con plaza
    public function plaza()
    {
        return $this->belongsTo(Plaza::class);
    }
}

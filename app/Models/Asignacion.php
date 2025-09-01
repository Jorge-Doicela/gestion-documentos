<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'plaza_id',
        'coordinador_id',
        'fecha_asignacion',
        'estado',
        'plan_trabajo'
    ];

    // Relaciones
    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function plaza()
    {
        return $this->belongsTo(Plaza::class);
    }

    public function coordinador()
    {
        return $this->belongsTo(User::class, 'coordinador_id');
    }
}

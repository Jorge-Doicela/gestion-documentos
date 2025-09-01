<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanTrabajo extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignacion_id',
        'objetivos',
        'actividades',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class);
    }
}

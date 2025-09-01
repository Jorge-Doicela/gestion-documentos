<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudPlaza extends Model
{
    use HasFactory;

    protected $fillable = [
        'plaza_id',
        'estudiante_id',
        'cv_ruta',
        'estado',
        'observaciones'
    ];

    public function plaza()
    {
        return $this->belongsTo(Plaza::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function planTrabajo()
    {
        return $this->hasOne(PlanTrabajo::class, 'solicitud_id');
    }
}

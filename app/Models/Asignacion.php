<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    // Aquí le decimos a Laravel cuál es la tabla real
    protected $table = 'asignaciones';

    protected $fillable = ['plaza_id', 'estudiante_id', 'supervisor_id', 'estado'];

    public function plaza()
    {
        return $this->belongsTo(Plaza::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function planTrabajo()
    {
        return $this->hasOne(PlanTrabajo::class);
    }
}

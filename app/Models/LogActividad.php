<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogActividad extends Model
{
    // Especifica la tabla asociada
    protected $table = 'logs_actividad';

    // Desactiva timestamps automáticos (created_at y updated_at)
    public $timestamps = false;

    // Campos asignables masivamente
    protected $fillable = [
        'user_id',
        'accion',
        'descripcion',
        'ip',
        'user_agent',
        'created_at',  // si deseas asignar manualmente created_at al crear el registro
    ];

    // Convierte created_at a objeto Carbon automáticamente
    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relación con el modelo User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

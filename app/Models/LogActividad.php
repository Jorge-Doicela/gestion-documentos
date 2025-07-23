<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActividad extends Model
{
    protected $table = 'logs_actividad';

    protected $fillable = [
        'user_id',
        'accion',
        'descripcion',
        'ip',
        'user_agent',
    ];

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}

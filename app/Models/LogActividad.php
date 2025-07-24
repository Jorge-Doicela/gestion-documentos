<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogActividad extends Model
{
    use HasFactory;

    protected $table = 'logs_actividad';

    protected $fillable = [
        'user_id',
        'accion',
        'descripcion',
        'ip',
        'user_agent',
    ];

    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];

    // Usuario relacionado
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

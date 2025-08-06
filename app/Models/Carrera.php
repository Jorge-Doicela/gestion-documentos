<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación inversa: una carrera tiene muchos usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}

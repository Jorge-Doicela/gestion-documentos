<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ruc',
        'direccion',
        'telefono',
        'email',
        'contacto',
    ];

    // Relación: una empresa tiene muchas plazas
    public function plazas()
    {
        return $this->hasMany(Plaza::class);
    }

    // Relación: una empresa tiene muchos convenios
    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }
}

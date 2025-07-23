<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relaciones
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function versionesCreadas()
    {
        return $this->hasMany(VersionDocumento::class, 'creado_por');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class);
    }

    public function logs()
    {
        return $this->hasMany(LogActividad::class);
    }

    public function certificadosFirmados()
    {
        return $this->hasMany(Certificado::class, 'firmado_por');
    }
}

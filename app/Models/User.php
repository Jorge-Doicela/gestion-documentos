<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

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

    // Relación con documentos subidos por el usuario
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    // Relación con certificados emitidos para el usuario
    public function certificados()
    {
        return $this->hasMany(Certificado::class);
    }

    // Comentarios que el usuario ha hecho
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    // Documentos donde el usuario es creador de versiones
    public function versionesCreadas()
    {
        return $this->hasMany(VersionDocumento::class, 'creado_por');
    }

    // Certificados firmados por el usuario (si es coordinador)
    public function certificadosFirmados()
    {
        return $this->hasMany(Certificado::class, 'firmado_por');
    }

    // Logs de actividad del usuario
    public function logsActividad()
    {
        return $this->hasMany(LogActividad::class);
    }
}

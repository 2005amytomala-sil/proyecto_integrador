<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    
    protected $fillable = [
            'rol_id',
            'ciudad_id',
            'cedula',
            'nombres',
            'apellidos',
            'email',
            'telefono',
            'direccion',
            'password',
            'activo'
    ];

    protected function hidden(): array
    {
        return [
            'password',
            'remember_token',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'ciudadano_id');
    }

    public function asignacionesRecibidas()
    {
        return $this->hasMany(Asignacion::class, 'usuario_id');
    }

    public function asignacionesRealizadas()
    {
        return $this->hasMany(Asignacion::class, 'operador_id');
    }

    public function cambiosEstado()
    {
        return $this->hasMany(HistorialEstado::class, 'usuario_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'usuario_id');
    }

    public function evidencias()
    {
        return $this->hasMany(Evidencia::class, 'usuario_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }
}

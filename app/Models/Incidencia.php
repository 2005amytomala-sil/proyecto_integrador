<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $table = 'incidencias';

    protected $fillable = [
        'ciudadano_id',
        'ciudad_id',
        'tipo_incidencia_id',
        'subtipo_incidencia_id',
        'estado_id',
        'prioridad_id',
        'titulo',
        'descripcion',
        'latitud',
        'longitud',
        'fecha_resolucion',
    ];

    protected function casts(): array
    {
        return [
            'latitud' => 'decimal:8',
            'longitud' => 'decimal:8',
            'fecha_resolucion' => 'datetime',
        ];
    }

    //Relaciones
    public function ciudadano()
    {
        return $this->belongsTo(User::class, 'ciudadano_id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function tipoIncidencia()
    {
        return $this->belongsTo(TipoIncidencia::class, 'tipo_incidencia_id');
    }

    public function subtipoIncidencia()
    {
        return $this->belongsTo(SubtipoIncidencia::class, 'subtipo_incidencia_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    public function historialEstados()
    {
        return $this->hasMany(HistorialEstado::class)
        ->orderBy('created_at', 'desc');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function evidencias()
    {
        return $this->hasMany(Evidencia::class);
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }
}

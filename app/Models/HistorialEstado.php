<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialEstado extends Model
{
    protected $table = 'historial_estados';

    protected $fillable = [
        'incidencia_id',
        'estado_id',
        'usuario_id',
        'observacion',
    ];

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'incidencia_id',
        'usuario_id',
        'operador_id',
        'tipo_asignacion',
        'observacion',
        'activo',
    ];

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id');
    }
}

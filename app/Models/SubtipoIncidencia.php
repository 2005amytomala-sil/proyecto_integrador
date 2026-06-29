<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubtipoIncidencia extends Model
{
    protected $table = 'subtipos_incidencia';

    protected $fillable = [
        'tipo_incidencia_id',
        'nombre',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoIncidencia::class, 'tipo_incidencia_id');
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'subtipo_incidencia_id');
    }
}

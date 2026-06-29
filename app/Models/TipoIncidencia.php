<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIncidencia extends Model
{
    protected $table = 'tipos_incidencia';

    protected $fillable = [
        'nombre',
    ];

    public function subtipos()
    {
        return $this->hasmany(SubTipoIncidencia::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'tipo_incidencia_id');
    }
}

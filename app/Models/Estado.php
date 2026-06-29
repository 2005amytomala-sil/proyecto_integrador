<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';

    protected $fillable = [
        'nombre',
        'orden',
    ];

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }

    public function historial()
    {
        return $this->hasMany(HistorialEstado::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades';

    protected $fillable = [
        'provincia_id',
        'nombre',
    ];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}

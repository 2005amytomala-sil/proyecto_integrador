<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incidencia;
use App\Models\User;
use App\Models\Ciudad;
use App\Models\TipoIncidencia;
use App\Models\SubtipoIncidencia;
use App\Models\Estado;
use App\Models\Prioridad;

class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Incidencia::create([

            'ciudadano_id' => User::where('email','juan@example.com')->first()->id,

            'ciudad_id' => Ciudad::where('nombre','La Libertad')->first()->id,

            'tipo_incidencia_id' => TipoIncidencia::where('nombre','Infraestructura')->first()->id,

            'subtipo_incidencia_id' => SubtipoIncidencia::where('nombre','Alumbrado público')->first()->id,

            'estado_id' => Estado::where('nombre','Registrada')->first()->id,

            'prioridad_id' => Prioridad::where('nombre','Alta')->first()->id,

            'titulo' => 'Poste de luz dañado',

            'descripcion' => 'El poste no funciona desde hace varios días y la zona permanece oscura.',

            'latitud' => -2.2294,

            'longitud' => -80.8583,

            'fecha_resolucion' => null,

        ]);
    }
}

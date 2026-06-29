<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asignacion;
use App\Models\Incidencia;
use App\Models\User;

class AsignacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Asignacion::create([

            'incidencia_id' => Incidencia::first()->id,

            'usuario_id' => User::where('email', 'responsable@example.com')->first()->id,

            'operador_id' => User::where('email', 'operador@example.com')->first()->id,

            'tipo_asignacion' => 'responsable',

            'observacion' => 'Se asigna la incidencia al responsable para su atención.',

            'activo' => true,

        ]);
    }
}

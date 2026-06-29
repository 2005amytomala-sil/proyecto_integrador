<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Evidencia;
use App\Models\Incidencia;
use App\Models\User;

class EvidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Evidencia::create([

            'incidencia_id' => Incidencia::first()->id,

            'usuario_id' => User::where('email', 'juan@example.com')->first()->id,

            'archivo' => 'incidencias/poste_luz_01.jpg',

            'tipo' => 'imagen',

            'descripcion' => 'Fotografía enviada por el ciudadano como evidencia del daño.',

        ]);
    }
}

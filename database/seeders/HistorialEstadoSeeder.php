<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HistorialEstado;
use App\Models\Incidencia;
use App\Models\Estado;
use App\Models\User;

class HistorialEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HistorialEstado::create([

            'incidencia_id' => Incidencia::first()->id,

            'estado_id' => Estado::where('nombre', 'En proceso')->first()->id,

            'usuario_id' => User::where('email', 'operador@example.com')->first()->id,

            'observacion' => 'La incidencia fue revisada y se inició el proceso de atención.',

        ]);
    }
}

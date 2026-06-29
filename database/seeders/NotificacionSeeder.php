<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notificacion;
use App\Models\User;
use App\Models\Incidencia;

class NotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notificacion::create([

            'usuario_id' => User::where('email', 'juan@example.com')->first()->id,

            'incidencia_id' => Incidencia::first()->id,

            'titulo' => 'Incidencia actualizada',

            'mensaje' => 'Su incidencia ha cambiado al estado En proceso.',

            'leida' => false,

        ]);
    }
}

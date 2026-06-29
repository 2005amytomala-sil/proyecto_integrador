<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comentario;
use App\Models\Incidencia;
use App\Models\User;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comentario::create([

            'incidencia_id' => Incidencia::first()->id,

            'usuario_id' => User::where('email', 'responsable@example.com')->first()->id,

            'contenido' => 'Se realizó la inspección del poste y se programó la reparación.',

        ]);
    }
}

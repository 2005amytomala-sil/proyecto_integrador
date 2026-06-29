<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoIncidencia;
use App\Models\SubtipoIncidencia;
use App\Models\Estado;
use App\Models\Prioridad;

class CatalogoIncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infraestructura = TipoIncidencia::create([
            'nombre' => 'Infraestructura',
        ]);

        $seguridad = TipoIncidencia::create([
            'nombre' => 'Seguridad',
        ]);

        SubtipoIncidencia::insert([
            [
                'tipo_incidencia_id' => $infraestructura->id,
                'nombre' => 'Alumbrado público',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_incidencia_id' => $infraestructura->id,
                'nombre' => 'Daño en vía',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_incidencia_id' => $seguridad->id,
                'nombre' => 'Robo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Estado::insert([
            ['nombre' => 'Registrada', 'orden' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Validada', 'orden' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'En proceso', 'orden' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Resuelta', 'orden' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Rechazada', 'orden' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cancelada', 'orden' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Prioridad::insert([
            ['nombre' => 'Alta', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Media', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Baja', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

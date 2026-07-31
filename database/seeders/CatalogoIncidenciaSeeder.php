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

        $ambiente = TipoIncidencia::create([
            'nombre' => 'Ambiente',
        ]);

        $servicios = TipoIncidencia::create([
            'nombre' => 'Servicios públicos',
        ]);

        $espacios = TipoIncidencia::create([
            'nombre' => 'Espacios públicos',
        ]);

        SubtipoIncidencia::insert([
            // Infraestructura
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
                'tipo_incidencia_id' => $infraestructura->id,
                'nombre' => 'Semáforo dañado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_incidencia_id' => $infraestructura->id,
                'nombre' => 'Señalización vial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_incidencia_id' => $infraestructura->id,
                'nombre' => 'Alcantarillado',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Seguridad
            [
                'tipo_incidencia_id' => $seguridad->id,
                'nombre' => 'Robo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_incidencia_id' => $seguridad->id,
                'nombre' => 'Accidente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_incidencia_id' => $seguridad->id,
                'nombre' => 'Vandalismo',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Ambiente
            [
                'tipo_incidencia_id' => $ambiente->id,
                'nombre' => 'Basura acumulada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_incidencia_id' => $ambiente->id,
                'nombre' => 'Árbol caído',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Servicios públicos
            [
                'tipo_incidencia_id' => $servicios->id,
                'nombre' => 'Corte de agua',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_incidencia_id' => $servicios->id,
                'nombre' => 'Fuga de agua',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Espacios públicos
            [
                'tipo_incidencia_id' => $espacios->id,
                'nombre' => 'Parque deteriorado',
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

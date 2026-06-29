<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            UbicacionSeeder::class,
            CatalogoIncidenciaSeeder::class,
            UserSeeder::class,
            IncidenciaSeeder::class,
            AsignacionSeeder::class,
            HistorialEstadoSeeder::class,
            ComentarioSeeder::class,
            EvidenciaSeeder::class,
            NotificacionSeeder::class,
        ]);
    }
}

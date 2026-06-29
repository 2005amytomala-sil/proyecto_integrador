<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::insert([
            ['nombre' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Operador', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Responsable', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ciudadano', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

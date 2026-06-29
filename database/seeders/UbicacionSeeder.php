<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pais;
use App\Models\Provincia;
use App\Models\Ciudad;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pais = Pais::create([
            'nombre' => 'Ecuador',
        ]);

        $provincia = Provincia::create([
            'pais_id' => $pais->id,
            'nombre' => 'Santa Elena',
        ]);

        Ciudad::insert([
            [
                'provincia_id' => $provincia->id,
                'nombre' => 'La Libertad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provincia_id' => $provincia->id,
                'nombre' => 'Salinas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provincia_id' => $provincia->id,
                'nombre' => 'Santa Elena',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

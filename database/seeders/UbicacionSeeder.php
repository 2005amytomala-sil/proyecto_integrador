<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pais;
use App\Models\Provincia;
use App\Models\Ciudad;

class UbicacionSeeder extends Seeder
{
    public function run(): void
    {
        $pais = Pais::create([
            'nombre' => 'Ecuador',
        ]);

        $ubicaciones = [

            'Azuay' => [
                [
                    'nombre' => 'Cuenca',
                    'latitud' => -2.900128,
                    'longitud' => -79.005897,
                ],
            ],

            'Bolívar' => [
                [
                    'nombre' => 'Guaranda',
                    'latitud' => -1.592634,
                    'longitud' => -79.000976,
                ],
            ],

            'Cañar' => [
                [
                    'nombre' => 'Azogues',
                    'latitud' => -2.739689,
                    'longitud' => -78.848602,
                ],
            ],

            'Carchi' => [
                [
                    'nombre' => 'Tulcán',
                    'latitud' => 0.811873,
                    'longitud' => -77.717270,
                ],
            ],

            'Chimborazo' => [
                [
                    'nombre' => 'Riobamba',
                    'latitud' => -1.663550,
                    'longitud' => -78.654646,
                ],
            ],

            'Cotopaxi' => [
                [
                    'nombre' => 'Latacunga',
                    'latitud' => -0.935210,
                    'longitud' => -78.615540,
                ],
            ],

            'El Oro' => [
                [
                    'nombre' => 'Machala',
                    'latitud' => -3.258111,
                    'longitud' => -79.955392,
                ],
            ],

            'Esmeraldas' => [
                [
                    'nombre' => 'Esmeraldas',
                    'latitud' => 0.968179,
                    'longitud' => -79.651720,
                ],
            ],

            'Galápagos' => [
                [
                    'nombre' => 'Puerto Ayora',
                    'latitud' => -0.743291,
                    'longitud' => -90.315689,
                ],
                [
                    'nombre' => 'Puerto Baquerizo Moreno',
                    'latitud' => -0.900000,
                    'longitud' => -89.610000,
                ],
            ],

            'Guayas' => [
                [
                    'nombre' => 'Guayaquil',
                    'latitud' => -2.189412,
                    'longitud' => -79.889066,
                ],
                [
                    'nombre' => 'Durán',
                    'latitud' => -2.170998,
                    'longitud' => -79.839869,
                ],
                [
                    'nombre' => 'Milagro',
                    'latitud' => -2.134040,
                    'longitud' => -79.594080,
                ],
            ],

            'Imbabura' => [
                [
                    'nombre' => 'Ibarra',
                    'latitud' => 0.351710,
                    'longitud' => -78.122330,
                ],
                [
                    'nombre' => 'Otavalo',
                    'latitud' => 0.234570,
                    'longitud' => -78.262480,
                ],
            ],

            'Loja' => [
                [
                    'nombre' => 'Loja',
                    'latitud' => -3.993130,
                    'longitud' => -79.204220,
                ],
            ],

            'Los Ríos' => [
                [
                    'nombre' => 'Babahoyo',
                    'latitud' => -1.801926,
                    'longitud' => -79.534645,
                ],
                [
                    'nombre' => 'Quevedo',
                    'latitud' => -1.028763,
                    'longitud' => -79.463522,
                ],
            ],

            'Manabí' => [
                [
                    'nombre' => 'Portoviejo',
                    'latitud' => -1.054578,
                    'longitud' => -80.454453,
                ],
                [
                    'nombre' => 'Manta',
                    'latitud' => -0.967653,
                    'longitud' => -80.708910,
                ],
                [
                    'nombre' => 'Chone',
                    'latitud' => -0.698190,
                    'longitud' => -80.093610,
                ],
            ],

            'Morona Santiago' => [
                [
                    'nombre' => 'Macas',
                    'latitud' => -2.308680,
                    'longitud' => -78.111350,
                ],
            ],

            'Napo' => [
                [
                    'nombre' => 'Tena',
                    'latitud' => -0.993800,
                    'longitud' => -77.812900,
                ],
            ],

            'Orellana' => [
                [
                    'nombre' => 'Francisco de Orellana',
                    'latitud' => -0.462170,
                    'longitud' => -76.986420,
                ],
            ],

            'Pastaza' => [
                [
                    'nombre' => 'Puyo',
                    'latitud' => -1.492150,
                    'longitud' => -78.002140,
                ],
            ],

            'Pichincha' => [
                [
                    'nombre' => 'Quito',
                    'latitud' => -0.180653,
                    'longitud' => -78.467834,
                ],
                [
                    'nombre' => 'Cayambe',
                    'latitud' => 0.040840,
                    'longitud' => -78.145240,
                ],
            ],

            'Santa Elena' => [
                [
                    'nombre' => 'Santa Elena',
                    'latitud' => -2.226220,
                    'longitud' => -80.858730,
                ],
                [
                    'nombre' => 'La Libertad',
                    'latitud' => -2.233330,
                    'longitud' => -80.900000,
                ],
                [
                    'nombre' => 'Salinas',
                    'latitud' => -2.214520,
                    'longitud' => -80.951510,
                ],
            ],

            'Santo Domingo de los Tsáchilas' => [
                [
                    'nombre' => 'Santo Domingo',
                    'latitud' => -0.253050,
                    'longitud' => -79.175360,
                ],
            ],

            'Sucumbíos' => [
                [
                    'nombre' => 'Nueva Loja',
                    'latitud' => 0.084720,
                    'longitud' => -76.882800,
                ],
            ],

            'Tungurahua' => [
                [
                    'nombre' => 'Ambato',
                    'latitud' => -1.254340,
                    'longitud' => -78.622850,
                ],
            ],

            'Zamora Chinchipe' => [
                [
                    'nombre' => 'Zamora',
                    'latitud' => -4.069000,
                    'longitud' => -78.956700,
                ],
            ],
        ];


        foreach ($ubicaciones as $nombreProvincia => $ciudades) {

            $provincia = Provincia::create([
                'pais_id' => $pais->id,
                'nombre' => $nombreProvincia,
            ]);


            foreach ($ciudades as $ciudad) {

                Ciudad::create([
                    'provincia_id' => $provincia->id,
                    'nombre' => $ciudad['nombre'],
                    'latitud' => $ciudad['latitud'],
                    'longitud' => $ciudad['longitud'],
                ]);

            }
        }
    }
}
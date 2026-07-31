<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ciudad;
use App\Models\Rol;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ciudad = Ciudad::where('nombre', 'La Libertad')->first();

        User::create([
            'rol_id' => Rol::where('nombre', 'Administrador')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000000',
            'nombres' => 'Administrador',
            'apellidos' => 'Sistema',
            'email' => 'admin@gmail.com',
            'telefono' => '0990000000',
            'direccion' => 'Municipio',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Operador')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000002',
            'nombres' => 'Carlos',
            'apellidos' => 'Morales',
            'email' => 'operador@gmail.com',
            'telefono' => '0991111111',
            'direccion' => 'Centro',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Responsable')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000003',
            'nombres' => 'María',
            'apellidos' => 'López',
            'email' => 'responsable@gmail.com',
            'telefono' => '0992222222',
            'direccion' => 'Centro',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Ciudadano')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000001',
            'nombres' => 'Juan',
            'apellidos' => 'Pérez',
            'email' => 'juan@gmail.com',
            'telefono' => '0999999999',
            'direccion' => 'Barrio Central',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Responsable')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000004',
            'nombres' => 'Pedro',
            'apellidos' => 'Sánchez',
            'email' => 'pedro.responsable@gmail.com',
            'telefono' => '0993333333',
            'direccion' => 'Puerto Azul',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Responsable')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000005',
            'nombres' => 'Ana',
            'apellidos' => 'Torres',
            'email' => 'ana.responsable@gmail.com',
            'telefono' => '0994444444',
            'direccion' => 'San Vicente',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Responsable')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000006',
            'nombres' => 'Luis',
            'apellidos' => 'Herrera',
            'email' => 'luis.responsable@gmail.com',
            'telefono' => '0995555555',
            'direccion' => 'Nueva Esperanza',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);


        // OPERADORES

        User::create([
            'rol_id' => Rol::where('nombre', 'Operador')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000007',
            'nombres' => 'José',
            'apellidos' => 'Mendoza',
            'email' => 'jose.operador@gmail.com',
            'telefono' => '0996666666',
            'direccion' => 'Centro',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Operador')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000008',
            'nombres' => 'Diego',
            'apellidos' => 'Castillo',
            'email' => 'diego.operador@gmail.com',
            'telefono' => '0997777777',
            'direccion' => 'Carretera Principal',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Operador')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000009',
            'nombres' => 'Andrea',
            'apellidos' => 'Ruiz',
            'email' => 'andrea.operador@gmail.com',
            'telefono' => '0998888888',
            'direccion' => 'Los Almendros',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);


        // CIUDADANOS

        User::create([
            'rol_id' => Rol::where('nombre', 'Ciudadano')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000010',
            'nombres' => 'Sofía',
            'apellidos' => 'García',
            'email' => 'sofia@gmail.com',
            'telefono' => '0991234567',
            'direccion' => 'Barrio Norte',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Ciudadano')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000011',
            'nombres' => 'Miguel',
            'apellidos' => 'Rodríguez',
            'email' => 'miguel@gmail.com',
            'telefono' => '0992345678',
            'direccion' => 'Barrio Sur',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Ciudadano')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000012',
            'nombres' => 'Valentina',
            'apellidos' => 'Castro',
            'email' => 'valentina@gmail.com',
            'telefono' => '0993456789',
            'direccion' => 'El Mirador',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

        User::create([
            'rol_id' => Rol::where('nombre', 'Ciudadano')->first()->id,
            'ciudad_id' => $ciudad->id,
            'cedula' => '2450000013',
            'nombres' => 'Daniel',
            'apellidos' => 'Zamora',
            'email' => 'daniel@gmail.com',
            'telefono' => '0994567890',
            'direccion' => 'Las Acacias',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);

    }
}

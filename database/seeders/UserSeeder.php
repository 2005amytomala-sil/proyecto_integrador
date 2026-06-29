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
            'email' => 'admin@example.com',
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
            'email' => 'operador@example.com',
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
            'email' => 'responsable@example.com',
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
            'email' => 'juan@example.com',
            'telefono' => '0999999999',
            'direccion' => 'Barrio Central',
            'password' => bcrypt('12345678'),
            'activo' => true,
        ]);
    }
}

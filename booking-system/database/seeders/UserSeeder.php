<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UserSeeder - Crea usuarios de ejemplo
 *
 * Este seeder crea un usuario administrador y varios usuarios clientes
 * para poder probar el sistema completo.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@booking.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+34 600 000 000',
        ]);

        // Usuarios clientes
        $clients = [
            [
                'name' => 'Juan Pérez',
                'email' => 'juan.perez@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone' => '+34 611 111 111',
            ],
            [
                'name' => 'Carmen Ruiz',
                'email' => 'carmen.ruiz@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone' => '+34 622 222 222',
            ],
            [
                'name' => 'Pedro González',
                'email' => 'pedro.gonzalez@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone' => '+34 633 333 333',
            ],
            [
                'name' => 'Isabel Fernández',
                'email' => 'isabel.fernandez@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'phone' => '+34 644 444 444',
            ],
        ];

        foreach ($clients as $client) {
            User::create($client);
        }
    }
}

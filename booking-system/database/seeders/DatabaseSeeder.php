<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder - Ejecuta todos los seeders en el orden correcto
 *
 * Este seeder principal ejecuta todos los demás seeders en el orden
 * necesario para que las relaciones de la base de datos funcionen correctamente.
 *
 * Orden de ejecución:
 * 1. UserSeeder - Crea usuarios (admin y clientes)
 * 2. ServiceSeeder - Crea los servicios ofrecidos
 * 3. ProfessionalSeeder - Crea los profesionales
 * 4. AvailabilitySeeder - Define horarios de disponibilidad
 * 5. BookingSeeder - Crea algunas reservas de ejemplo
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
            ProfessionalSeeder::class,
            AvailabilitySeeder::class,
            BookingSeeder::class,
        ]);
    }
}

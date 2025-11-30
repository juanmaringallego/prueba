<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * ServiceSeeder - Crea servicios de ejemplo
 *
 * Este seeder crea una variedad de servicios típicos de un salón de belleza/spa.
 * Cada servicio tiene un nombre, descripción, duración (en minutos) y precio.
 */
class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Corte de Cabello',
                'description' => 'Corte personalizado adaptado a tu estilo y tipo de cabello',
                'duration' => 30,
                'price' => 25.00,
                'is_active' => true,
            ],
            [
                'name' => 'Corte y Peinado',
                'description' => 'Corte completo con lavado, secado y peinado profesional',
                'duration' => 60,
                'price' => 45.00,
                'is_active' => true,
            ],
            [
                'name' => 'Coloración',
                'description' => 'Tinte completo con productos premium y protección del cabello',
                'duration' => 120,
                'price' => 80.00,
                'is_active' => true,
            ],
            [
                'name' => 'Mechas/Highlights',
                'description' => 'Mechas californianas o highlights para iluminar tu cabello',
                'duration' => 90,
                'price' => 95.00,
                'is_active' => true,
            ],
            [
                'name' => 'Manicura',
                'description' => 'Manicura completa con esmaltado tradicional',
                'duration' => 45,
                'price' => 20.00,
                'is_active' => true,
            ],
            [
                'name' => 'Pedicura',
                'description' => 'Pedicura spa con exfoliación y masaje',
                'duration' => 60,
                'price' => 35.00,
                'is_active' => true,
            ],
            [
                'name' => 'Manicura Semipermanente',
                'description' => 'Esmaltado semipermanente que dura hasta 3 semanas',
                'duration' => 60,
                'price' => 35.00,
                'is_active' => true,
            ],
            [
                'name' => 'Tratamiento Capilar',
                'description' => 'Tratamiento nutritivo e hidratante para tu cabello',
                'duration' => 45,
                'price' => 40.00,
                'is_active' => true,
            ],
            [
                'name' => 'Alisado/Keratina',
                'description' => 'Tratamiento de alisado con keratina de larga duración',
                'duration' => 180,
                'price' => 150.00,
                'is_active' => true,
            ],
            [
                'name' => 'Depilación Facial',
                'description' => 'Depilación de cejas, labio superior y/o mentón',
                'duration' => 30,
                'price' => 15.00,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Professional;
use Illuminate\Database\Seeder;

/**
 * AvailabilitySeeder - Crea horarios de disponibilidad
 *
 * Este seeder define los horarios en que cada profesional está disponible.
 * Crea un horario típico de lunes a sábado de 9:00 a 18:00.
 */
class AvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        $professionals = Professional::all();
        $workDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        foreach ($professionals as $professional) {
            foreach ($workDays as $day) {
                // Horario de mañana: 9:00 - 14:00
                Availability::create([
                    'professional_id' => $professional->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00',
                    'end_time' => '14:00',
                    'is_available' => true,
                ]);

                // Horario de tarde: 16:00 - 20:00 (excepto sábado)
                if ($day !== 'Saturday') {
                    Availability::create([
                        'professional_id' => $professional->id,
                        'day_of_week' => $day,
                        'start_time' => '16:00',
                        'end_time' => '20:00',
                        'is_available' => true,
                    ]);
                }
            }
        }
    }
}

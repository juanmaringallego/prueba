<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Professional;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * BookingSeeder - Crea reservas de ejemplo
 *
 * Este seeder crea algunas reservas de prueba con diferentes estados
 * para poder ver cómo funciona el sistema completo.
 */
class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $clients = User::where('role', 'client')->get();
        $professionals = Professional::all();
        $services = Service::all();

        // Crear algunas reservas de ejemplo
        $bookings = [
            [
                'user_id' => $clients[0]->id,
                'professional_id' => $professionals[0]->id,
                'service_id' => $services[0]->id, // Corte de Cabello
                'booking_date' => Carbon::today()->addDays(1),
                'start_time' => '10:00',
                'end_time' => '10:30',
                'status' => 'confirmed',
                'notes' => 'Prefiero corte corto',
            ],
            [
                'user_id' => $clients[1]->id,
                'professional_id' => $professionals[2]->id,
                'service_id' => $services[4]->id, // Manicura
                'booking_date' => Carbon::today()->addDays(2),
                'start_time' => '11:00',
                'end_time' => '11:45',
                'status' => 'pending',
                'notes' => null,
            ],
            [
                'user_id' => $clients[0]->id,
                'professional_id' => $professionals[1]->id,
                'service_id' => $services[1]->id, // Corte y Peinado
                'booking_date' => Carbon::today()->addDays(3),
                'start_time' => '16:00',
                'end_time' => '17:00',
                'status' => 'confirmed',
                'notes' => 'Para evento especial',
            ],
            [
                'user_id' => $clients[2]->id,
                'professional_id' => $professionals[0]->id,
                'service_id' => $services[2]->id, // Coloración
                'booking_date' => Carbon::today()->addDays(5),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'status' => 'pending',
                'notes' => 'Quiero un tono castaño claro',
            ],
            [
                'user_id' => $clients[3]->id,
                'professional_id' => $professionals[3]->id,
                'service_id' => $services[7]->id, // Tratamiento Capilar
                'booking_date' => Carbon::today()->subDays(2),
                'start_time' => '14:00',
                'end_time' => '14:45',
                'status' => 'completed',
                'notes' => 'Cabello muy seco',
            ],
            [
                'user_id' => $clients[1]->id,
                'professional_id' => $professionals[2]->id,
                'service_id' => $services[5]->id, // Pedicura
                'booking_date' => Carbon::today()->subDays(5),
                'start_time' => '10:00',
                'end_time' => '11:00',
                'status' => 'cancelled',
                'notes' => 'Cancelada por el cliente',
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }
    }
}

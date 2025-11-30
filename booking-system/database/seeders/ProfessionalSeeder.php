<?php

namespace Database\Seeders;

use App\Models\Professional;
use Illuminate\Database\Seeder;

/**
 * ProfessionalSeeder - Crea profesionales de ejemplo
 *
 * Este seeder crea profesionales con diferentes especializaciones
 * para atender los diferentes servicios del salón.
 */
class ProfessionalSeeder extends Seeder
{
    public function run(): void
    {
        $professionals = [
            [
                'name' => 'María García',
                'email' => 'maria.garcia@salon.com',
                'phone' => '+34 600 111 222',
                'specialization' => 'Peluquería y Coloración',
                'bio' => 'Estilista con 10 años de experiencia en cortes y coloración. Especializada en mechas y balayage.',
                'is_active' => true,
            ],
            [
                'name' => 'Carlos Rodríguez',
                'email' => 'carlos.rodriguez@salon.com',
                'phone' => '+34 600 222 333',
                'specialization' => 'Barbería y Cortes Modernos',
                'bio' => 'Barbero profesional especializado en cortes masculinos y estilos modernos.',
                'is_active' => true,
            ],
            [
                'name' => 'Ana Martínez',
                'email' => 'ana.martinez@salon.com',
                'phone' => '+34 600 333 444',
                'specialization' => 'Manicura y Pedicura',
                'bio' => 'Técnica de uñas certificada con especialización en nail art y esmaltados semipermanentes.',
                'is_active' => true,
            ],
            [
                'name' => 'Laura Sánchez',
                'email' => 'laura.sanchez@salon.com',
                'phone' => '+34 600 444 555',
                'specialization' => 'Tratamientos Capilares',
                'bio' => 'Experta en tratamientos de keratina, alisados y restauración capilar.',
                'is_active' => true,
            ],
            [
                'name' => 'Javier López',
                'email' => 'javier.lopez@salon.com',
                'phone' => '+34 600 555 666',
                'specialization' => 'Estilismo Integral',
                'bio' => 'Estilista versátil con experiencia en todo tipo de servicios de peluquería.',
                'is_active' => true,
            ],
        ];

        foreach ($professionals as $professional) {
            Professional::create($professional);
        }
    }
}

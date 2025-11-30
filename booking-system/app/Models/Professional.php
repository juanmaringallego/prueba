<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Professional - Representa a los profesionales que ofrecen servicios
 *
 * Este modelo gestiona la información de los profesionales (peluqueros,
 * manicuristas, etc.) que atienden a los clientes.
 *
 * Relaciones:
 * - hasMany Booking: Un profesional puede tener múltiples reservas
 * - hasMany Availability: Un profesional tiene múltiples horarios de disponibilidad
 */
class Professional extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'bio',
        'is_active',
    ];

    /**
     * Conversión de tipos de atributos
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relación: Un profesional puede tener múltiples reservas
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relación: Un profesional tiene múltiples horarios de disponibilidad
     */
    public function availability(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * Scope: Obtener solo profesionales activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

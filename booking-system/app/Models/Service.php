<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Service - Representa los servicios ofrecidos
 *
 * Este modelo gestiona los servicios que se pueden reservar en el sistema.
 * Cada servicio tiene un nombre, descripción, duración y precio.
 *
 * Relaciones:
 * - hasMany Booking: Un servicio puede tener múltiples reservas
 */
class Service extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente
     * Estos campos pueden ser llenados mediante create() o fill()
     */
    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'is_active',
    ];

    /**
     * Conversión de tipos de atributos
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relación: Un servicio puede tener múltiples reservas
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}

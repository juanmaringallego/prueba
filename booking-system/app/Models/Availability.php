<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Availability - Representa la disponibilidad de un profesional
 *
 * Este modelo gestiona los horarios en que cada profesional está disponible
 * para atender clientes. Define días de la semana y rangos horarios.
 *
 * Relaciones:
 * - belongsTo Professional: La disponibilidad pertenece a un profesional
 */
class Availability extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos
     */
    protected $table = 'availability';

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'professional_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_available',
    ];

    /**
     * Conversión de tipos de atributos
     */
    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    /**
     * Relación: La disponibilidad pertenece a un profesional
     */
    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Scope: Obtener solo horarios disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope: Obtener disponibilidad para un día específico
     */
    public function scopeForDay($query, $day)
    {
        return $query->where('day_of_week', $day);
    }
}

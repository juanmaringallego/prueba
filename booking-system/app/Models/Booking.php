<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Booking - Representa una reserva de turno
 *
 * Este modelo gestiona las reservas realizadas por los usuarios.
 * Cada reserva conecta un usuario, un profesional y un servicio
 * en una fecha y hora específicas.
 *
 * Relaciones:
 * - belongsTo User: La reserva pertenece a un usuario
 * - belongsTo Professional: La reserva es atendida por un profesional
 * - belongsTo Service: La reserva es para un servicio específico
 */
class Booking extends Model
{
    use HasFactory;

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'user_id',
        'professional_id',
        'service_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    /**
     * Conversión de tipos de atributos
     */
    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }

    /**
     * Relación: La reserva pertenece a un usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: La reserva es atendida por un profesional
     */
    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Relación: La reserva es para un servicio específico
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Scope: Obtener reservas pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Obtener reservas confirmadas
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope: Obtener reservas para una fecha específica
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('booking_date', $date);
    }
}

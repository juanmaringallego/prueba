<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * BookingController - Controlador de Reservas
 *
 * Este controlador maneja todas las operaciones CRUD relacionadas con las reservas de turnos.
 * Incluye validación de disponibilidad, verificación de conflictos de horarios y gestión de estados.
 *
 * Métodos principales:
 * - index(): Lista todas las reservas del usuario autenticado
 * - create(): Muestra el formulario para crear una nueva reserva
 * - store(): Guarda una nueva reserva en la base de datos
 * - show(): Muestra los detalles de una reserva específica
 * - update(): Actualiza el estado de una reserva
 * - destroy(): Cancela una reserva
 */
class BookingController extends Controller
{
    /**
     * Muestra una lista de las reservas del usuario autenticado
     * Los administradores ven todas las reservas, los clientes solo las suyas
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Los administradores ven todas las reservas
            $bookings = Booking::with(['user', 'professional', 'service'])
                ->orderBy('booking_date', 'desc')
                ->orderBy('start_time', 'desc')
                ->paginate(15);
        } else {
            // Los clientes solo ven sus propias reservas
            $bookings = $user->bookings()
                ->with(['professional', 'service'])
                ->orderBy('booking_date', 'desc')
                ->orderBy('start_time', 'desc')
                ->paginate(15);
        }

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Muestra el formulario para crear una nueva reserva
     * Carga todos los servicios y profesionales activos
     */
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $professionals = Professional::where('is_active', true)->get();

        return view('bookings.create', compact('services', 'professionals'));
    }

    /**
     * Guarda una nueva reserva en la base de datos
     * Valida que no haya conflictos de horario y que el profesional esté disponible
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'professional_id' => 'required|exists:professionals,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        // Obtener el servicio para calcular la hora de fin
        $service = Service::findOrFail($validated['service_id']);

        // Calcular hora de fin basada en la duración del servicio
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // Verificar si ya existe una reserva para ese profesional en ese horario
        $conflict = Booking::where('professional_id', $validated['professional_id'])
            ->where('booking_date', $validated['booking_date'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                    ->orWhereBetween('end_time', [$startTime->format('H:i'), $endTime->format('H:i')]);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'El profesional ya tiene una reserva en ese horario.'])->withInput();
        }

        // Crear la reserva
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'professional_id' => $validated['professional_id'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', '¡Reserva creada exitosamente!');
    }

    /**
     * Muestra los detalles de una reserva específica
     */
    public function show(Booking $booking)
    {
        // Verificar que el usuario pueda ver esta reserva
        if (!Auth::user()->isAdmin() && $booking->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver esta reserva.');
        }

        $booking->load(['user', 'professional', 'service']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Muestra el formulario para editar una reserva
     */
    public function edit(Booking $booking)
    {
        // Solo el dueño o un admin pueden editar
        if (!Auth::user()->isAdmin() && $booking->user_id !== Auth::id()) {
            abort(403);
        }

        $services = Service::where('is_active', true)->get();
        $professionals = Professional::where('is_active', true)->get();

        return view('bookings.edit', compact('booking', 'services', 'professionals'));
    }

    /**
     * Actualiza una reserva en la base de datos
     * Permite cambiar el estado o modificar los detalles
     */
    public function update(Request $request, Booking $booking)
    {
        // Solo el dueño o un admin pueden actualizar
        if (!Auth::user()->isAdmin() && $booking->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'sometimes|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Reserva actualizada exitosamente.');
    }

    /**
     * Cancela una reserva (soft delete conceptual mediante cambio de estado)
     */
    public function destroy(Booking $booking)
    {
        // Solo el dueño o un admin pueden cancelar
        if (!Auth::user()->isAdmin() && $booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.index')
            ->with('success', 'Reserva cancelada exitosamente.');
    }

    /**
     * Obtiene los horarios disponibles para un profesional en una fecha específica
     * Este método es útil para AJAX/API calls desde el frontend
     */
    public function getAvailableSlots(Request $request)
    {
        $validated = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'date' => 'required|date',
            'service_id' => 'required|exists:services,id',
        ]);

        $professional = Professional::findOrFail($validated['professional_id']);
        $service = Service::findOrFail($validated['service_id']);
        $date = Carbon::parse($validated['date']);

        // Obtener las reservas existentes del profesional para esa fecha
        $existingBookings = Booking::where('professional_id', $professional->id)
            ->where('booking_date', $date->toDateString())
            ->where('status', '!=', 'cancelled')
            ->get(['start_time', 'end_time']);

        // Aquí se podría implementar lógica más compleja para calcular slots disponibles
        // basándose en la disponibilidad del profesional y las reservas existentes

        return response()->json([
            'available_slots' => [], // Implementar lógica de slots
            'booked_slots' => $existingBookings,
        ]);
    }
}

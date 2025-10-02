<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!auth('sanctum')->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();
        $role = $user->role;

        // Admin a accès total
        if ($role === 'admin') {
            return $next($request);
        }

        // Organizer : accès à ses propres événements et billets
        if ($role === 'organizer') {
            // Vérifier si la route concerne un événement
            $event = $this->getEventFromRequest($request);
            if ($event && $event->created_by !== $user->id) {
                return response()->json([
                    'message' => 'Forbidden: You can only access your own events',
                ], Response::HTTP_FORBIDDEN);
            }
            return $next($request);
        }

        // Customer : accès à ses propres réservations
        if ($role === 'customer') {
            // Vérifier si la route concerne une réservation
            $bookingId = $request->route('id');
            if ($request->is('api/bookings/*') && $bookingId) {
                $booking = \App\Models\Booking::find($bookingId);
                if ($booking && $booking->user_id !== $user->id) {
                    return response()->json([
                        'message' => 'Forbidden: You can only access your own bookings',
                    ], Response::HTTP_FORBIDDEN);
                }
            }
            // Autoriser les customers à réserver des billets
            if ($request->is('api/tickets/*/bookings') || $request->is('api/bookings')) {
                return $next($request);
            }

            return response()->json([
                'message' => 'Forbidden: Customers cannot access this resource',
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->json([
            'message' => 'Forbidden: Invalid role',
        ], Response::HTTP_FORBIDDEN);
    }

    protected function getEventFromRequest(Request $request): ?Event
    {
        // Extraire l'événement depuis les paramètres de la route
        $eventId = $request->route('id') ?: $request->route('event_id');
        if ($eventId) {
            return Event::find($eventId);
        }
        return null;
    }
}
<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDoubleBooking
{
    public function handle(Request $request, Closure $next): Response
    {
        $ticketId = $request->route('id');
        $userId = auth()->id();

        if (Booking::where('user_id', $userId)->where('ticket_id', $ticketId)->exists()) {
            return response()->json(['message' => 'You already have a booking for this ticket'], 422);
        }

        return $next($request);
    }
}
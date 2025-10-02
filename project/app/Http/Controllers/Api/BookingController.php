<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->get();
        return response()->json(['data' => $bookings], 200);
    }

    public function store(StoreBookingRequest $request)
    {
        $ticket = Ticket::findOrFail($request->route('id'));

        $booking = DB::transaction(function () use ($request, $ticket) {
            $ticket->decrement('quantity', $request->quantity);
            return Booking::create([
                'user_id' => auth()->id(),
                'ticket_id' => $ticket->id,
                'quantity' => $request->quantity,
                'status' => 'pending',
            ]);
        });

        return response()->json(['data' => $booking, 'message' => 'Booking created'], 201);
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking->update(['status' => 'cancelled']);
        $booking->ticket->increment('quantity', $booking->quantity);

        return response()->json(['message' => 'Booking cancelled'], 200);
    }
}
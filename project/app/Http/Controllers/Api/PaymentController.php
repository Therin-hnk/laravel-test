<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request)
    {
        $booking = Booking::findOrFail($request->route('id'));
        $amount = $booking->quantity * $booking->ticket->price;

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $amount,
            'status' => rand(0, 10) > 2 ? 'success' : 'failed', // Simulation 80% succès
        ]);

        if ($payment->status === 'success') {
            $booking->update(['status' => 'confirmed']);
        }

        return response()->json(['data' => $payment, 'message' => 'Payment processed'], 201);
    }

    public function show(Payment $payment)
    {
        if ($payment->booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['data' => $payment], 200);
    }
}
<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function processPayment(Booking $booking): Payment
    {
        return DB::transaction(function () use ($booking) {
            $amount = $booking->quantity * $booking->ticket->price;
            $status = rand(0, 10) > 2 ? 'success' : 'failed'; // 80% succès

            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $amount,
                'status' => $status,
            ]);

            if ($status === 'success') {
                $booking->update(['status' => 'confirmed']);
            }

            return $payment;
        });
    }
}
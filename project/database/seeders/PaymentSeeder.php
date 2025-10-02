<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer toutes les réservations confirmées
        $bookings = Booking::where('status', 'confirmed')->get();

        // Créer un paiement pour chaque réservation
        foreach ($bookings as $booking) {
            $ticket = $booking->ticket;
            Payment::factory()->create([
                'booking_id' => $booking->id,
                'amount' => $booking->quantity * $ticket->price, // Calculer montant
                'status' => 'success', // Paiement réussi pour cohérence
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les clients et billets
        $customers = User::where('role', 'customer')->get();
        $tickets = Ticket::all();

        // Créer 20 réservations
        for ($i = 0; $i < 20; $i++) {
            $ticket = $tickets->random();
            $customer = $customers->random();

            Booking::factory()->create([
                'user_id' => $customer->id,
                'ticket_id' => $ticket->id,
                'quantity' => rand(1, 3), // 1 à 3 billets par réservation
                'status' => 'confirmed', // Majorité confirmée pour paiements
            ]);
        }
    }
}
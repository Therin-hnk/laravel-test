<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les événements
        $events = Event::all();

        // Créer 3 billets par événement (3 * 5 = 15 billets)
        foreach ($events as $event) {
            Ticket::factory()->create([
                'event_id' => $event->id,
                'type' => 'VIP',
                'price' => 150.00,
                'quantity' => 20,
            ]);

            Ticket::factory()->create([
                'event_id' => $event->id,
                'type' => 'Standard',
                'price' => 75.00,
                'quantity' => 50,
            ]);

            Ticket::factory()->create([
                'event_id' => $event->id,
                'type' => 'Economy',
                'price' => 30.00,
                'quantity' => 100,
            ]);
        }
    }
}
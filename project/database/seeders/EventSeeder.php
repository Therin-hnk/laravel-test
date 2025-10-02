<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les organisateurs
        $organizers = User::where('role', 'organizer')->get();

        // Créer 5 événements, chacun lié à un organisateur
        foreach ($organizers as $index => $organizer) {
            Event::factory()->create([
                'created_by' => $organizer->id,
                'title' => 'Événement ' . ($index + 1),
                'date' => now()->addDays($index * 30), // Événements espacés dans le temps
                'location' => ['Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice'][$index % 5],
            ]);
        }
    }
}
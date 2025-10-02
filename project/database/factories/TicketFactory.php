<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['VIP', 'Standard', 'Economy']),
            'price' => $this->faker->randomFloat(2, 10, 500), // Prix entre 10.00 et 500.00
            'quantity' => $this->faker->numberBetween(10, 100), // Stock initial
            'event_id' => Event::factory(), // Crée un événement si non spécifié
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
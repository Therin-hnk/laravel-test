<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->customer(), // Crée un client
            'ticket_id' => Ticket::factory(), // Crée un ticket
            'quantity' => $this->faker->numberBetween(1, 5), // 1 à 5 billets réservés
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
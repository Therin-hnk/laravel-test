<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Mot de passe par défaut
            'phone' => $this->faker->phoneNumber(),
            'role' => $this->faker->randomElement(['admin', 'organizer', 'customer']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    // État pour créer un admin
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }

    // État pour créer un organisateur
    public function organizer()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'organizer',
            ];
        });
    }

    // État pour créer un client
    public function customer()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'customer',
            ];
        });
    }
}
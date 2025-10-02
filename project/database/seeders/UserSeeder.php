<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Créer 2 admins
        User::factory()->admin()->count(2)->create();

        // Créer 3 organisateurs
        User::factory()->organizer()->count(3)->create();

        // Créer 10 clients
        User::factory()->customer()->count(10)->create();
    }
}
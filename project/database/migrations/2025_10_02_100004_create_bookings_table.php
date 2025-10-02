<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK vers users.id
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade'); // FK vers tickets.id
            $table->unsignedInteger('quantity')->default(1); // INT UNSIGNED NOT NULL
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // ENUM NOT NULL
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at pour soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
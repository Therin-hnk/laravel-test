<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade'); // FK vers bookings.id
            $table->decimal('amount', 8, 2); // DECIMAL(8,2) NOT NULL
            $table->enum('status', ['success', 'failed', 'refunded'])->default('failed'); // ENUM NOT NULL
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at pour soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
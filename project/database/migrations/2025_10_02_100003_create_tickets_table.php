<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->enum('type', ['VIP', 'Standard', 'Economy'])->default('Standard'); // ENUM NOT NULL
            $table->decimal('price', 8, 2); // DECIMAL(8,2) NOT NULL
            $table->unsignedInteger('quantity'); // INT UNSIGNED NOT NULL
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade'); // FK vers events.id
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at pour soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
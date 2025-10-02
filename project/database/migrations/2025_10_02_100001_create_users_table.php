<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name'); // VARCHAR(255) NOT NULL
            $table->string('email')->unique(); // VARCHAR(255) UNIQUE NOT NULL
            $table->string('password'); // VARCHAR(255) NOT NULL
            $table->string('phone', 20)->nullable(); // VARCHAR(20) NULL
            $table->enum('role', ['admin', 'organizer', 'customer'])->default('customer'); // ENUM NOT NULL
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
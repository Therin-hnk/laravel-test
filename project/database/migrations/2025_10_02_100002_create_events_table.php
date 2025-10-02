<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('title'); // VARCHAR(255) NOT NULL
            $table->text('description')->nullable(); // TEXT NULL
            $table->dateTime('date'); // DATETIME NOT NULL
            $table->string('location'); // VARCHAR(255) NOT NULL
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // FK vers users.id
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at pour soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
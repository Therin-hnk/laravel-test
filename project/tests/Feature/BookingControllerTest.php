<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_booking_and_decrements_quantity()
    {
        $customer = User::factory()->customer()->create();
        $ticket = Ticket::factory()->create(['quantity' => 10]);
        $this->actingAs($customer, 'sanctum');

        $response = $this->postJson("/api/tickets/{$ticket->id}/bookings", ['quantity' => 2]);

        $response->assertStatus(201)
            ->assertJsonFragment(['quantity' => 2]);
        $this->assertDatabaseHas('bookings', ['user_id' => $customer->id, 'ticket_id' => $ticket->id]);
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'quantity' => 8]);
    }

    public function test_store_prevents_double_booking()
    {
        $customer = User::factory()->customer()->create();
        $ticket = Ticket::factory()->create(['quantity' => 10]);
        Booking::factory()->create(['user_id' => $customer->id, 'ticket_id' => $ticket->id]);
        $this->actingAs($customer, 'sanctum');

        $response = $this->postJson("/api/tickets/{$ticket->id}/bookings", ['quantity' => 2]);

        $response->assertStatus(422)
            ->assertJson(['message' => 'You already have a booking for this ticket']);
    }

    public function test_index_returns_user_bookings()
    {
        $customer = User::factory()->customer()->create();
        Booking::factory()->count(2)->create(['user_id' => $customer->id]);
        $this->actingAs($customer, 'sanctum');

        $response = $this->getJson('/api/bookings');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_cancel_updates_status_and_increments_quantity()
    {
        $customer = User::factory()->customer()->create();
        $ticket = Ticket::factory()->create(['quantity' => 10]);
        $booking = Booking::factory()->create(['user_id' => $customer->id, 'ticket_id' => $ticket->id, 'quantity' => 2]);
        $this->actingAs($customer, 'sanctum');

        $response = $this->putJson("/api/bookings/{$booking->id}/cancel");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Booking cancelled']);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'cancelled']);
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'quantity' => 12]);
    }
}
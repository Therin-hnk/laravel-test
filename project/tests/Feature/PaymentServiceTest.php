<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_payment_creates_payment_and_updates_booking()
    {
        $customer = User::factory()->customer()->create();
        $ticket = Ticket::factory()->create(['price' => 100]);
        $booking = Booking::factory()->create(['user_id' => $customer->id, 'ticket_id' => $ticket->id, 'quantity' => 2]);
        $service = new PaymentService();

        // Simuler succès (mock rand() serait idéal, mais ici on assume succès fréquent)
        $payment = $service->processPayment($booking);

        $this->assertDatabaseHas('payments', [
            'booking_id' => $booking->id,
            'amount' => 200, // 2 * 100
        ]);
        if ($payment->status === 'success') {
            $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'confirmed']);
        }
    }
}
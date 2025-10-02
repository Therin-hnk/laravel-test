<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_events()
    {
        Event::factory()->count(15)->create();

        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['data', 'current_page', 'per_page']]);
    }

    public function test_index_filters_by_search()
    {
        Event::factory()->create(['title' => 'Concert Rock']);
        Event::factory()->create(['title' => 'Jazz Festival']);

        $response = $this->getJson('/api/events?search=Concert');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonFragment(['title' => 'Concert Rock']);
    }

    public function test_show_returns_event_with_tickets()
    {
        $event = Event::factory()->create();
        $event->tickets()->createMany([
            ['type' => 'VIP', 'price' => 150, 'quantity' => 20],
            ['type' => 'Standard', 'price' => 75, 'quantity' => 50],
        ]);

        $response = $this->getJson("/api/events/{$event->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'title', 'tickets' => [['id', 'type', 'price']]]]);
    }

    public function test_store_creates_event_for_organizer()
    {
        $organizer = User::factory()->organizer()->create();
        $this->actingAs($organizer, 'sanctum');

        $response = $this->postJson('/api/events', [
            'title' => 'New Event',
            'description' => 'Description',
            'date' => now()->addDay()->format('Y-m-d H:i:s'),
            'location' => 'Paris',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'New Event']);
        $this->assertDatabaseHas('events', ['title' => 'New Event', 'created_by' => $organizer->id]);
    }

    public function test_store_fails_for_customer()
    {
        $customer = User::factory()->customer()->create();
        $this->actingAs($customer, 'sanctum');

        $response = $this->postJson('/api/events', [
            'title' => 'New Event',
            'description' => 'Description',
            'date' => now()->addDay()->format('Y-m-d H:i:s'),
            'location' => 'Paris',
        ]);

        $response->assertStatus(403)
            ->assertJson(['message' => 'Unauthorized']);
    }
}
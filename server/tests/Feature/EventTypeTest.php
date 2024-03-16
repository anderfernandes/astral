<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventTypeTest extends TestCase
{
    /**
     * Authenticate before interacting with app.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs($this->user);
    }

    /**
     * Tests index event types get all.
     */
    public function test_event_types_index(): void
    {
        $response = $this->get('/api/event-types');

        $response->assertStatus(200);
    }

    /**
     * Tests storing event types to the database.
     */
    public function test_event_types_store(): void
    {
        $response = $this->post('/api/event-types', [
            'name' => fake()->name,
            'description' => fake()->text,
            'is_public' => fake()->boolean
        ]);

        $response->assertStatus(201);
    }

    /**
     * Tests updating event type.
     * TODO: ENSURE ALLOWED EVENTS IS TESTED TOO
     */
    public function test_event_types_update(): void
    {
        $eventType = $this->get('/api/event-types')->json()['data'][0]['id'];

        $response = $this->put("/api/event-types/$eventType", [
            'name' => fake()->name,
            'description' => fake()->text
        ]);

        $response->assertStatus(200);
    }

}

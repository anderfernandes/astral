<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventTest extends TestCase
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
     * Tests if an array of current date's events is returned.
     */
    public function test_events_index(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->get('/api/events');

        $response->assertStatus(200);
    }

    /**
     * Test if application stores events.
     */
    public function test_events_store(): void
    {
        $start = Carbon::create(fake()->dateTime);

        $response = $this->post('/api/events', [
            [
                'is_public' => fake()->boolean,
                'start' => $start,
                'end' => $start->addHour(),
                'memo' => fake()->text,
                'show_id' => 2,
                'type_id' => 2,
                'seats' => fake()->numberBetween(10, 100)
            ]
        ]);

        // TODO: ENSURE MEMOS ARE BEING SAVED!

        //var_dump($response->json());

        $response->assertStatus(201);
    }

    /**
     * Test if application stores updated event data.
     */
    public function test_events_update(): void
    {
        $start = Carbon::create(fake()->dateTime)->startOfDay()
            ->addHours(fake()->numberBetween(8, 22));

        $event = $this->get('/api/events/2');

        $response = $this->put('/api/events/2', [
            ...$event->json(),
            'start' => $start,
            'end' => $start->addHour(),
            'memo' => fake()->text,
            'seats' => $event->json('seats.available')
        ]);

        // TODO: ENSURE MEMOS ARE BEING SAVED!

        //var_dump($response->json());

        $response->assertStatus(200);
    }
}

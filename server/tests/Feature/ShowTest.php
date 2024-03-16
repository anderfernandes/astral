<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowTest extends TestCase
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
     * Tests if applications returns shows from the database.
     */
    public function test_shows_get_all(): void
    {
        $response = $this->get('/api/shows');

        $response->assertStatus(200);
    }

    /**
     * Tests if a new show is saved onto the database.
     */
    public function test_show_store(): void
    {
        $response = $this->post('/api/shows', [
            'name' => fake()->name,
            'duration' => fake()->numberBetween(1, 90),
            'description' => fake()->text,
            'type_id' => 1,
        ]);

        $response->assertStatus(201);
    }

    /**
     * Tests if a single show is returned.
     */
    public function test_show_show(): void
    {
        $response = $this->get('/api/shows/2');

        $response->assertStatus(200);
    }

    /**
     * Tests if a show is properly updated.
     */
    public function test_show_update(): void
    {
        $response = $this->put('/api/shows/2', [
            'name' => fake()->name,
            'type_id' => 2,
            'duration' => fake()->numberBetween(1, 90),
            'description' => fake()->text
        ]);

        $response->assertStatus(200);
    }
}

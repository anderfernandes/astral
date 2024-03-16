<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TicketTypeTest extends TestCase
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
     * A basic feature test example.
     */
    public function test_ticket_types_index(): void
    {
        $response = $this->get('/api/ticket-types');

        $response->assertStatus(200);
    }

    /**
     * Tests storing ticket types into the database.
     */
    public function test_ticket_types_store(): void
    {
        $response = $this->post('/api/ticket-types', [
            'name' => fake()->name,
            'price' => fake()->randomFloat(2, 2, 2),
            'is_active' => true,
            'is_public' => fake()->boolean,
            'description' => fake()->text,
            'in_cashier' => fake()->boolean
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test updating ticket types.
     */
    public function test_ticket_types_update(): void
    {
        $id = $this->get('/api/ticket-types')->json('data')[0]['id'];

        $response = $this->put("api/ticket-types/$id", [
            'name' => fake()->name,
            'price' => fake()->randomFloat(2, 2, 2),
            'is_active' => true,
            'is_public' => fake()->boolean,
            'description' => fake()->text,
            'in_cashier' => fake()->boolean
        ]);

        $response->assertStatus(200);
    }
}

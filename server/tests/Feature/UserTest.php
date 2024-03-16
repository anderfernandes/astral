<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
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
    public function test_users_index(): void
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);
    }

    /**
     * Test new user save to database.
     */
    public function test_users_store(): void
    {
        $response = $this->post('/api/users', [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => fake()->email,
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test user show.
     */
    public function test_users_show(): void
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);
    }

    public function test_users_update(): void
    {
        $response = $this->put('/api/users/2', [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => fake()->email,
        ]);

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MembershipTypeTest extends TestCase
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
     * Test getting membership types.
     */
    public function test_membership_types_index(): void
    {
        $response = $this->get('/api/membership-types');

        $response->assertStatus(200);
    }
    
    /**
     * Test getting one membership type by id.
     */
    public function test_membership_type_show(): void
    {
        $response = $this->get('/api/membership-types/1');
        
        $response->assertStatus(200);
    }
    
    /**
     * Store new membership type
     */
    public function test_membership_type_store(): void
    {
        $response = $this->post('/api/membership-types', [
            'name' => fake()->name,
            'description' => fake()->text,
            'price' => fake()->randomFloat(2),
            'duration' => 365,
            'max_secondaries' => fake()->randomDigit(),
            'secondary_price' => fake()->randomFloat(2),
        ]);
        
        $response->assertCreated();
    }
    
/**
     * Store new membership type
     */
    public function test_membership_type_update(): void
    {
        $membershipType = end($this->get('/api/membership-types')->json()['data']);

        $response = $this->put("/api/membership-types/{$membershipType['id']}", [
            'name' => fake()->name,
            'description' => fake()->text,
            'price' => fake()->randomFloat(2),
            'duration' => 365,
            'max_secondaries' => fake()->randomDigit(),
            'secondary_price' => fake()->randomFloat(2),
        ]);
        
        $response->assertOk();
    }
}

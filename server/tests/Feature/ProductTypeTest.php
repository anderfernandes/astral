<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTypeTest extends TestCase
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
     * Tests product types get all.
     */
    public function test_product_types_index(): void
    {
        $response = $this->get('/api/product-types');

        $response->assertStatus(200);
    }

    /**
     * Tests if product types are stored.
     */
    public function test_product_types_store(): void
    {
        $response = $this->post('/api/product-types/', [
            'name' => fake()->name,
            'description' => fake()->text
        ]);

        $response->assertStatus(201);
    }

    /**
     * Tests if product types are stored.
     */
    public function test_product_types_update(): void
    {
        $response = $this->put('/api/product-types/1', [
            'name' => fake()->name,
            'description' => fake()->text
        ]);

        $response->assertStatus(200);
    }
}

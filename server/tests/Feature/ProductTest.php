<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
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
     * Tests getting all products.
     */
    public function test_products_index(): void
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    /**
     * Tests saving a product into the database.
     */
    public function test_products_store(): void
    {
        $response = $this->post('/api/products', [
            'name' => 'Test Product',
            'price' => 9.99,
            'description' => fake()->text,
            'type_id' => 2,
            'inventory' => true,
            'stock' => 100,
            'is_active' => true,
            'is_public' => true,
            'in_cashier' => true
        ]);

        $response->assertStatus(201);
    }

    /**
     * Tests get one product.
     */
    public function test_products_show(): void
    {
        $response = $this->get('/api/products/2');

        $response->assertStatus(200);
    }

    /**
     * Tests update product.
     */
    public function test_products_update(): void
    {
        $product_id = $this->get('/api/products/2')->json('id');

        $response = $this->put("/api/products/$product_id", [
            'name' => 'Updated Test Product',
            'price' => 19.99,
            'description' => fake()->text,
            'type_id' => 2,
        ]);

        $response->assertStatus(200);
    }
}

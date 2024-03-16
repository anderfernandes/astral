<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SaleMemoTest extends TestCase
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
    public function test_sale_memo_store(): void
    {
        $sale_id = $this->post('/api/sales', [
            'products' => [
                ['id' => 3, 'quantity' => 3]
            ],
            'method_id' => 1,
            'tendered' => 6,
            'customer_id' => $this->user->id,
        ])->json('data');

        $response = $this->post('/api/sales/memos', [
            'message' => fake()->text,
            'author_id' => 1,
            'sale_id' => $sale_id
        ]);
        
        $response->assertStatus(201);
    }
}

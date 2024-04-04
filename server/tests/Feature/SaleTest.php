<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SaleTest extends TestCase
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
     * Test getting
     */
    public function test_sales_index(): void
    {
        $response = $this->get('/api/sales');

        $response->assertStatus(200);
    }

    /**
     * Testing store sale with products into the database.
     */
    public function test_sales_store_with_products(): void
    {
        $response = $this->post('/api/sales', [
            'products' => [
                ['id' => 3, 'quantity' => 3]
            ],
            'method_id' => 1,
            'tendered' => 6,
            'customer_id' => $this->user->id,
        ]);

        $response->assertStatus(201);
    }

    /**
     * Testing storing sale with tickets into the database.
     */
    public function test_sales_store_with_tickets(): void
    {
        $start = Carbon::create(fake()->dateTime);

        $id = $this->post('/api/events', [
            [
                'is_public' => fake()->boolean,
                'start' => $start,
                'end' => $start->addHour(),
                'memo' => fake()->text,
                'show_id' => 2,
                'type_id' => 2,
                'seats' => fake()->numberBetween(10, 100)
            ]
        ])['data'];

        $response = $this->post('/api/sales', [
            'tickets' => [
                ['type_id' => 3, 'event_id' => $id, 'quantity' => 2],
                ['type_id' => 2, 'event_id' => $id, 'quantity' => 2]
            ],
            'method_id' => 1,
            'tendered' => 6,
            'customer_id' => $this->user->id,
        ]);

        $response->assertStatus(201);
    }

    /**
     * Testing if a sale is getting refunded.
     */
    public function test_sales_refund(): void
    {
        $response = $this->delete('/api/sales/1');

        $response->assertStatus(200);
    }

    public function test_sales_with_stripe_payment(): void
    {
        $start = Carbon::create(fake()->dateTime);

        $id = $this->post('/api/events', [
            [
                'is_public' => fake()->boolean,
                'start' => $start,
                'end' => $start->addHour(),
                'memo' => fake()->text,
                'show_id' => 2,
                'type_id' => 2,
                'seats' => fake()->numberBetween(10, 100)
            ]
        ])['data'];

        $response = $this->post('/api/stripe/session/create', [
            'tickets' => [
                ['type_id' => 3, 'event_id' => $id, 'quantity' => 2],
                ['type_id' => 2, 'event_id' => $id, 'quantity' => 2]
            ],
            'method_id' => 1,
            'tendered' => 6,
            'customer_id' => $this->user->id,
        ]);

        dd($response->json());

        $response->assertStatus(200);
    }
}

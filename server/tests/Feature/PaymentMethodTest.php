<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
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
    public function test_payment_methods_index(): void
    {
        $response = $this->get('/api/payment-methods');

        $response->assertStatus(200);
    }
}

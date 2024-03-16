<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowTypeTest extends TestCase
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
    public function test_show_types_index(): void
    {
        $response = $this->get('/api/show-types');

        $response->assertStatus(200);
    }
}

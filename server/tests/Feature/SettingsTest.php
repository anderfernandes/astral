<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SettingsTest extends TestCase
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
     * Tests if settings are being returned with unauthenticated values.
     */
    public function test_settings_index(): void
    {
        $response = $this->get('/api/settings');

        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has('version')->has('organization')->etc());
    }

    /**
     * Tests if more data is returned when settings is requested while authenticated.
     */
    public function test_settings_index_authenticated(): void
    {
        $response = $this->get('/api/settings');

        $response->assertStatus(200);
    }

    public function test_settings_update(): void
    {
        $response = $this->post('/api/settings', [
            'organization' => fake()->name,
            'seats' => fake()->numberBetween(1, 500),
            'address' => fake()->address,
            'is_astc_member' => fake()->boolean,
            'phone' => fake()->phoneNumber,
            'email' => fake()->email
        ]);

        $response->assertStatus(200);
    }
}

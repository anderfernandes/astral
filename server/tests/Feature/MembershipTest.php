<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MembershipTest extends TestCase
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
    public function test_memberships_index(): void
    {
        $response = $this->get('/api/memberships');

        $response->assertOk();
    }
    
/**
     * A basic feature test example.
     */
    public function test_membership_show(): void
    {
        $response = $this->get('/api/memberships/1');

        $response->assertOk();
    }
    
    /**
     * Tests creation of a new membership without secondaries.
     */
    public function test_membership_store(): void
    {
        $primary = $this->get('/api/users/2')->json();
        $membershipType = $this->get('/api/membership-types/2')->json();
        $method = $this->get('/api/payment-methods')->json()['data'][1];
        
        $response = $this->post('/api/memberships', [
            'primary_id' => $primary['id'],
            //'secondaries' => [],
            'type_id' => $membershipType['id'],
            'tendered' => $membershipType['price'],
            'method_id' => $method['id'],
            'reference' => '1234',
            //'start' => ['nullable', 'date']
        ]);
        
        $response->assertCreated();
    }
    
/**
     * Tests creation of a new membership without secondaries.
     */
    public function test_membership_store_with_secondaries(): void
    {
        $users = $this->get('/api/users')->json()['data'];
        shuffle($users);
        $users = array_slice($users, 0, 3);
        $membershipType = $this->get('/api/membership-types/2')->json();
        $method = $this->get('/api/payment-methods')->json()['data'][1];
        
        $response = $this->post('/api/memberships', [
            'primary_id' => $users[0]['id'],
            'secondaries' => [$users[1]['id'], $users[2]['id']],
            'type_id' => $membershipType['id'],
            'tendered' => $membershipType['price'],
            'method_id' => $method['id'],
            'reference' => '1234',
            //'start' => ['nullable', 'date']
        ]);
        
        $response->assertCreated();
    }
}

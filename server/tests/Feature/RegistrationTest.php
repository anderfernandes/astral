<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * Tests user registration with valid data.
     */
    public function test_registration(): void
    {
        $email = fake()->email;
        $password = fake()->password(8);

        $response = $this->post('/api/register', [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => $email,
            'email_confirmation' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(201);
    }

    /**
     * Tests registration validation
     */
    public function test_registration_with_invalid_data(): void
    {
        $response = $this->post('/api/register', [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => fake()->email,
            'password' => fake()->password,
            'password_confirmation' => fake()->password
        ]);

        $response->assertStatus(422);
    }

    /**
     * Tests account verification
     */
    public function test_account_verification(): void
    {
        $user = DB::table('users')->whereNotNull('id')->get()->last();
        $hash = fake()->sha1;

        $response = $this->get("/api/verify/$user->id/$hash");

        $response->assertStatus(302);
    }
}

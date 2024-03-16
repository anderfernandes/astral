<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordRecoveryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests password recovery strategy with valid data.
     */
    public function test_account_register(): void
    {
        $email = fake()->email;
        $password = fake()->password;

        $this->post('/api/register', [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response = $this->post('/api/forgot', [
            'email' => $email,
        ], [
            "HEADER_X_FORWARDED_HOST" => "192.168.1.187"
        ]);

        $response->assertStatus(200);
    }

    /**
     * Tests password recovery with unregistered email. Should return 404.
     */
    public function test_password_forgot_with_unregistered_email(): void
    {
        $response = $this->post('/api/forgot', [
            'email' => fake()->email,
        ]);

        $response->assertStatus(404);
    }

    /**
     * Tests password recovery validation.
     */
    public function test_password_forgot_validation(): void
    {
        $response = $this->post('/api/forgot', [
            'email' => fake()->name
        ]);

        $response->assertStatus(422);
    }

    /**
     * Tests forgot password functionality when the user send an updated password
     */
    public function test_password_forgot(): void
    {
        $password = fake()->password;

        $response = $this->post('/api/forgot-password', [
            'token' => sha1($this->user->email),
            'email' => $this->user->email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(404);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * Tests user login
     */
    public function test_login(): void
    {
        $email = fake()->email;
        $password = fake()->password(8);

        $this->post('/api/register', [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response = $this->post('/api/login', [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(200);
    }

    /**
     * Tests login validation rules
     */
    public function test_login_validation(): void
    {
        $email = fake()->email;
        $password = fake()->password;

        $this->post('/api/register', [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response = $this->post('/api/login', [
            'email' => $email
        ]);

        $response->assertStatus(422);
    }

    public function test_login_with_wrong_password(): void
    {
        $email = fake()->email;
        $password = fake()->password;

        $this->post('/api/register', [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response = $this->post('/api/login', [
            'email' => $email,
            'password' => fake()->password
        ]);

        $response->assertStatus(401);
    }
}

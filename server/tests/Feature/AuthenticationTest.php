<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * Indicates whether the default seeder should run before each test.
     */
    protected bool $seed = false;

    protected User $user;
    protected string $password;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->make();
        $this->password = fake()->password(8);
    }

    public function test_register(): void
    {
        $response = $this->post('/api/register', [
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'email' => $this->user->email,
            'email_confirmation' => $this->user->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ]);

        $response->assertStatus(201);
    }

    public function test_login(): void
    {
        $this->post('/api/register', [
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'email' => $this->user->email,
            'email_confirmation' => $this->user->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ]);

        $response = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => $this->password,
        ]);

        $response->assertStatus(200);
    }

    public function test_login_validation(): void
    {
        $response = $this->post('/api/login', [
            'email' => $this->user->email
        ]);

        $response->assertStatus(422);
    }

    public function test_login_with_wrong_password(): void
    {
        $this->post('/api/register', [
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'email' => $this->user->email,
            'email_confirmation' => $this->user->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ]);

        $response = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => fake()->password
        ]);

        $response->assertStatus(401);
    }
}

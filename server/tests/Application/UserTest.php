<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserTest extends BaseWebTestCase
{
    public function testIndex(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('GET', '/users');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateMissingData()
    {
        $this->client->loginUser($this->user);

        $this->client->catchExceptions(false);
        $this->expectException(HttpException::class);

        $faker = \Faker\Factory::create();

        $this->client->request('POST', '/users', [
            'email' => $faker->email(),
            'password' => $faker->password(),
            'lastName' => $faker->lastName(),
            'address' => $faker->streetAddress(),
            'city' => $faker->city(),
            'state' => 'Texas',
            'zip' => (string) $faker->randomNumber(5),
            'country' => $faker->country(),
            'phone' => $faker->phoneNumber(),
            'dateOfBirth' => $faker->date(),
        ]);

        $this->assertResponseIsUnprocessable();
    }

    public function testShowWithBadId()
    {
        $this->client->loginUser($this->user);

        $this->client->catchExceptions(false);
        $this->expectException(HttpException::class);

        $this->client->request('GET', '/users/99');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testUpdateAndShow()
    {
        $this->client->loginUser($this->user);

        $faker = \Faker\Factory::create();

        $this->client->request('GET', '/users/1');

        $user = json_decode($this->client->getResponse()->getContent(), true);

        $this->client->request('PUT', '/users/1', [
            ...$user,
            'address' => $faker->address(),
            'emailConfirmation' => $user['email'],
            'passwordConfirmation' => $user['password']
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testUpdateWithBadData()
    {
        $this->client->loginUser($this->user);

        $this->client->catchExceptions(false);
        $this->expectException(HttpException::class);

        $faker = \Faker\Factory::create();

        $this->client->request('PUT', '/users/2', []);

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}

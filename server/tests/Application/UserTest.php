<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class UserTest extends BaseWebTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /**
         * @var EntityManagerInterface $entityManger
         */
        $entityManger = static::getContainer()->get(EntityManagerInterface::class);

        $entityManger->persist(self::$user);
        $entityManger->flush();

        self::ensureKernelShutdown();
    }

    public function testCreate(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        // $client->catchExceptions(false);
        // $this->expectException(HttpException::class);

        $faker = \Faker\Factory::create();

        $email = $faker->email();
        $password = $faker->password();

        $user = [
            'email' => $email,
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'address' => $faker->streetAddress(),
            'city' => $faker->city(),
            'state' => 'Texas',
            'zip' => (string) $faker->randomNumber(5),
            'country' => $faker->country(),
            'phone' => $faker->phoneNumber(),
            'dateOfBirth' => $faker->date(),
        ];

        // Act

        $client->request('POST', '/users', $user);

        $id = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/users/$id");

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals($data['email'], $email);
    }

    public function testCreateWithMissingData(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        $faker = \Faker\Factory::create();

        // Act

        $client->request('POST', '/users', [
            'password' => $faker->password(),
            'lastName' => $faker->lastName(),
            'address' => $faker->streetAddress(),
            'city' => $faker->city(),
            'state' => 'Texas',
            'zip' => (string) $faker->randomNumber(5),
            'country' => 'United States',
            'phone' => $faker->phoneNumber(),
            'dateOfBirth' => $faker->date(),
        ]);

        // Assert

        $this->assertResponseIsUnprocessable();
    }

    public function testShowWithBadId(): void
    {
        // Arrange

        $client = static::createClient();

        $client->catchExceptions(false);
        $this->expectException(HttpException::class);

        $client->loginUser(self::$user);

        // Act

        $client->request('GET', '/users/99');

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testUpdate(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        $client->request('GET', '/users/2');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $faker = \Faker\Factory::create();
        $address = $faker->address();

        // Act

        $client->request('PUT', '/users/2', [
            ...$data,
            'address' => $address,
            'emailConfirmation' => $data['email'],
            'passwordConfirmation' => $data['password'],
        ]);

        $client->request('GET', '/users/2');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals($data['address'], $address);
    }

    public function testUpdateWithBadData(): void
    {
        // Arrange

        $client = static::createClient();

        $client->catchExceptions(false);
        $this->expectException(\TypeError::class);

        $client->loginUser(self::$user);

        // Act

        $client->request('PUT', '/users/2', [
            'email' => 'test@test.com',
        ]);

        // Assert

        $this->assertResponseIsUnprocessable();
    }

    public function testIndex(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        // Act

        $client->request('GET', '/users');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        // Assert

        $this->assertCount(2, $data);
    }

    public function testIndexWithoutAuthentication(): void
    {
        // Arrange

        $client = static::createClient();

        $client->catchExceptions(false);
        $this->expectException(AccessDeniedException::class);

        // Act

        $client->request('GET', '/users');

        // dd($client->getResponse()->getStatusCode());

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetUsersWhoAreMembers(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $client->request('GET', '/users?isMember=true');

        // dd($client->getResponse()->getStatusCode());

        // Assert

        $data = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $this->assertCount(0, $data);
    }

    public function testGetUsersWhoAreNotMembers(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $client->request('GET', '/users?isMember=false');

        // Assert

        $data = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $this->assertTrue(count($data) > 0);
    }
}

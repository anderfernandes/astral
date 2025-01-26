<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class AccountTest extends BaseWebTestCase
{
    public static array $customer;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $faker = \Faker\Factory::create();

        /**
         * @var $entityManager EntityManagerInterface
         */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $password = $faker->realTextBetween(6, 12);
        $email = $faker->email();

        self::$customer = [
            'email' => $email,
            'emailConfirmation' => $email,
            'password' => $password,
            'passwordConfirmation' => $password,
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'address' => $faker->streetAddress(),
            'city' => $faker->city(),
            'state' => 'Texas',
            'zip' => $faker->randomNumber(5),
            'country' => $faker->country(),
            'phone' => $faker->phoneNumber(),
            'dateOfBirth' => $faker->date(),
        ];

        $entityManager->flush();

        self::ensureKernelShutdown();
    }

    public function testRegister(): void
    {
        // Arrange

        $client = static::createClient();

        // Act

        $client->request('POST', '/register', self::$customer);

        // Assert
        $this->assertResponseIsSuccessful();
    }

    public function testLogin(): void
    {
        // Arrange

        $client = static::createClient();

        // Act

        $client->request('POST', '/login', [
            'email' => self::$customer['email'],
            'password' => self::$customer['password'],
        ]);

        // Assert

        $this->assertResponseIsSuccessful();
    }

    public function testLoginWithBadCredentials(): void
    {
        // Arrange

        $client = static::createClient();

        // Act

        $client->request('POST', '/login', [
            'email' => self::$customer['email'],
            'password' => \Faker\Factory::create()->password(),
        ]);

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testShowAccount(): void
    {
        // Arrange

        $client = static::createClient();

        $client->request('POST', '/login', [
            'email' => self::$customer['email'],
            'password' => self::$customer['password'],
        ]);

        // Act

        $client->request('GET', '/account');

        // Assert

        $this->assertResponseIsSuccessful();
    }

    public function testShowWithoutLogin()
    {
        // Arrange

        $client = static::createClient();

        // Act

        $client->request('GET', '/account');

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testActivation(): void
    {
        // Arrange

        $client = static::createClient();

        $faker = \Faker\Factory::create();

        $password = $faker->realTextBetween(6, 12);
        $email = $faker->email();

        $client->request('POST', '/register', [
            'email' => $email,
            'emailConfirmation' => $email,
            'password' => $password,
            'passwordConfirmation' => $password,
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'address' => $faker->streetAddress(),
            'city' => $faker->city(),
            'state' => 'Texas',
            'zip' => $faker->randomNumber(5),
            'country' => $faker->country(),
            'phone' => $faker->phoneNumber(),
            'dateOfBirth' => $faker->date(),
        ]);

        $crawler = new Crawler($this->getMailerMessage()->getHtmlBody());

        $uri = $crawler->filter('a.button')->last()->link()->getUri();

        // Act

        $client->request('GET', $uri);

        // Assert

        $this->assertResponseIsSuccessful();
    }

    public function testActivationWithBadToken(): void
    {
        // Arrange

        $client = static::createClient();

        $faker = \Faker\Factory::create();

        $password = $faker->realTextBetween(6, 12);
        $email = $faker->email();

        $client->request('POST', '/register', [
            'email' => $email,
            'emailConfirmation' => $email,
            'password' => $password,
            'passwordConfirmation' => $password,
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'address' => $faker->streetAddress(),
            'city' => $faker->city(),
            'state' => 'Texas',
            'zip' => $faker->randomNumber(5),
            'country' => $faker->country(),
            'phone' => $faker->phoneNumber(),
            'dateOfBirth' => $faker->date(),
        ]);

        $crawler = new Crawler($this->getMailerMessage()->getHtmlBody());

        $uri = $crawler->filter('a.button')->last()->link()->getUri();

        // Act

        $token = \Faker\Factory::create()->sha1();

        $client->request('GET', "/activate?token=$token");

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testActivationWithoutToken(): void
    {
        // Arrange

        $client = static::createClient();

        $faker = \Faker\Factory::create();

        $password = $faker->realTextBetween(6, 12);
        $email = $faker->email();

        $client->request('POST', '/register', [
            'email' => $email,
            'emailConfirmation' => $email,
            'password' => $password,
            'passwordConfirmation' => $password,
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'address' => $faker->streetAddress(),
            'city' => $faker->city(),
            'state' => 'Texas',
            'zip' => $faker->randomNumber(5),
            'country' => $faker->country(),
            'phone' => $faker->phoneNumber(),
            'dateOfBirth' => $faker->date(),
        ]);

        $crawler = new Crawler($this->getMailerMessage()->getHtmlBody());

        $uri = $crawler->filter('a.button')->last()->link()->getUri();

        // Act

        $client->request('GET', '/activate');

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testLogout(): void
    {
        // Arrange

        $client = static::createClient();

        $client->request('POST', '/login', [
            'email' => self::$customer['email'],
            'password' => self::$customer['password'],
        ]);

        // Act

        $client->request('POST', '/logout');

        // Assert
        $this->assertResponseIsSuccessful();
    }

    public function testLogoutWithoutLogin()
    {
        // Arrange

        $client = static::createClient();

        // Act
        $client->request('POST', '/logout');

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testUpdateAccount(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->request('POST', '/login', [
            'email' => self::$customer['email'],
            'password' => self::$customer['password'],
        ]);

        // Act

        $client->request('PUT', '/account', [
            ...self::$customer,
            'address' => \Faker\Factory::create()->address(),
        ]);

        // Assert

        $client->request('GET', '/account');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $this->assertNotNull($data['updatedAt']);
    }

    public function testForgot(): void
    {
        // Arrange

        $client = static::createClient();

        $client->request('POST', '/forgot', [
            'email' => self::$customer['email'],
        ]);

        $crawler = new Crawler($this->getMailerMessage()->getHtmlBody());

        $uri = $crawler->filter('a.button')->last()->link()->getUri();

        $password = $faker = \Faker\Factory::create()->password();

        // Act

        $client->request('POST', $uri, [
            'password' => $password,
            'passwordConfirmation' => $password,
        ]);

        // Assert

        $this->assertResponseIsSuccessful();
    }

    public function testForgotWithoutEmail(): void
    {
        // Arrange

        $client = static::createClient();

        // Act

        $client->request('POST', '/forgot', [
            'email' => \Faker\Factory::create()->email(),
        ]);

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}

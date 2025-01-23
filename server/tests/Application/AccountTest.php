<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class AccountTest extends BaseWebTestCase
{
    private array $newUser;

    public function setUp(): void
    {
        parent::setUp();

        $faker = \Faker\Factory::create();

        $password = $faker->realTextBetween(6, 12);
        $email = $faker->email();

        $this->newUser = [
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
    }

    public function testRegister(): void
    {
        // Arrange

        $client = static::createClient();

        // Act

        $client->request('POST', '/register', $this->newUser);

        // Assert
        $this->assertResponseIsSuccessful();
    }

    public function testLogin(): void
    {
        // Arrange

        $client = static::createClient();

        $client->request('POST', '/register', $this->newUser);

        // Act

        $client->request('POST', '/login', [
            'email' => $this->newUser['email'],
            'password' => $this->newUser['password'],
        ]);

        // Assert

        $this->assertResponseIsSuccessful();
    }

    public function testLoginWithBadCredentials(): void
    {
        // Arrange

        $client = static::createClient();

        $client->request('POST', '/register', $this->newUser);

        // Act

        $client->request('POST', '/login', [
            'email' => $this->newUser['email'],
            'password' => 'test',
        ]);

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testShowAccount(): void
    {
        // Arrange

        $client = static::createClient();

        $client->request('POST', '/register', $this->newUser);

        $client->request('POST', '/login', [
            'email' => $this->newUser['email'],
            'password' => $this->newUser['password'],
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

        $client->request('POST', '/register', $this->newUser);

        // Act

        $client->request('GET', '/account');

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testActivation(): void
    {
        // Arrange

        $client = static::createClient();

        $client->request('POST', '/register', $this->newUser);

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

        $client->request('POST', '/register', $this->newUser);

        $crawler = new Crawler($this->getMailerMessage()->getHtmlBody());

        $uri = $crawler->filter('a.button')->last()->link()->getUri();

        // Act

        $client->request('GET', '/activate?token=atesttoken');

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testActivationWithoutToken(): void
    {
        // Arrange

        $client = static::createClient();

        $client->request('POST', '/register', $this->newUser);

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

        $client->request('POST', '/register', $this->newUser);

        $client->request('POST', '/login', [
            'email' => $this->newUser['email'],
            'password' => $this->newUser['password'],
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

        $client->request('POST', '/register', $this->newUser);

        $client->request('POST', '/login', [
            'email' => $this->newUser['email'],
            'password' => $this->newUser['password'],
        ]);

        // Act

        $client->request('PUT', '/account', $this->newUser);

        // Assert

        $client->request('GET', '/account');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $this->assertNotNull($data['updatedAt']);
    }

    public function testForgot(): void
    {
        // Arrange

        $client = static::createClient();

        $client->request('POST', '/register', $this->newUser);

        $client->request('POST', '/forgot', [
            'email' => $this->newUser['email'],
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

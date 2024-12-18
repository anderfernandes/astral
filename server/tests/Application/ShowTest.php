<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ShowTest extends BaseWebTestCase
{
    public array $show;

    public function setUp(): void
    {
        parent::setUp();

        $this->show = [
            'name' => 'Test Show',
            'typeId' => 1,
            'duration' => rand(15, 45),
            'description' => 'A random description for a show test',
            'isActive' => rand(0, 1),
            'trailerUrl' => \Faker\Factory::create()->url(),
            'expiration' => (new \DateTime('+5 years'))->format('c'),
        ];
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/shows');

        $this->assertResponseIsSuccessful();
    }

    public function testCreate(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/shows', $this->show, [
            'cover' => new UploadedFile(
                static::getContainer()->getParameter('uploads_dir').'/default.png',
                'default.png'
            ),
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateWithoutCover(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/shows', $this->show);

        $this->assertResponseIsSuccessful();
    }

    public function testShow(): void
    {
        $this->client->loginUser($this->user);
        
        $this->client->request('POST', '/shows', $this->show);

        $this->client->request('GET', '/shows/2');

        $this->assertResponseIsSuccessful();
    }

    public function testUpdate(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/shows', [
            ...$this->show,
            'name' => 'Updated Show Name',
            'description' => 'Updated show description'
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testUpdateWithCover(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/shows', $this->show, [
            'cover' => new UploadedFile(
                static::getContainer()->getParameter('uploads_dir').'/default.png',
                'default.png'
            ),
        ]);

        $this->assertResponseIsSuccessful();
    }
}
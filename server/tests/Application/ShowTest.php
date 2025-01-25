<?php

namespace App\Tests\Application;

use App\Entity\ShowType;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class ShowTest extends BaseWebTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /**
         * @var $entityManger EntityManagerInterface
         */
        $entityManger = static::getContainer()->get(EntityManagerInterface::class);

        $entityManger->persist(self::$user);

        $entityManger->persist(new ShowType(
            name: 'Test Show Type',
            description: 'The description of a Test Show Type',
            creator: self::$user,
            isActive: true
        ));

        $entityManger->flush();

        self::ensureKernelShutdown();
    }

    public function testCreate(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        // Act

        $client->request('POST', '/shows', [
            'name' => 'Test Show',
            'typeId' => 1,
            'duration' => rand(15, 45),
            'description' => 'A random description for a test show',
            'isActive' => rand(0, 1),
            'trailerUrl' => \Faker\Factory::create()->url(),
            'expiration' => (new \DateTime('+5 years'))->format('c'),
        ],
            [
                'cover' => new UploadedFile(
                    static::getContainer()->getParameter('uploads_dir').'/default.png',
                    'default.png'
                ),
            ]);

        $id = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/shows/$id");

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertNotEquals('default.png', $data['cover']);
    }

    public function testCreateWithoutCover(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        // Act

        $client->request('POST', '/shows', [
            'name' => 'Another Test Show',
            'typeId' => 1,
            'duration' => rand(15, 45),
            'description' => 'A random description for a another test show',
            'isActive' => rand(0, 1),
            'expiration' => (new \DateTime('+5 years'))->format('c'),
        ]);

        $id = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/shows/$id");

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals('/default.png', $data['cover']);
    }

    public function testUpdate(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        // Act

        $client->request('PUT', '/shows/2', [
            'name' => 'Updated Test Show',
            'typeId' => 1,
            'duration' => rand(15, 45),
            'description' => 'A random description for a another test show',
            'isActive' => rand(0, 1),
            'expiration' => (new \DateTime('+5 years'))->format('c'),
        ],
            [
                'cover' => new UploadedFile(
                    static::getContainer()->getParameter('uploads_dir').'/default.png',
                    'default.png'
                ),
            ]);

        $client->request('GET', '/shows/2');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertNotEquals('default.png', $data['cover']);
    }

    public function testUpdateShowRemovingCover(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        // Act

        $client->request('PUT', '/shows/2', [
            'name' => 'Updated Test Show',
            'typeId' => 1,
            'duration' => rand(15, 45),
            'description' => 'A random description for a another test show',
            'isActive' => rand(0, 1),
            'expiration' => (new \DateTime('+5 years'))->format('c'),
        ]);

        $client->request('GET', '/shows/2');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals('default.png', $data['cover']);
    }

    public function testIndex(): void
    {
        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->request('GET', '/shows');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $this->assertCount(2, $data);
    }
}

<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class ShowTypeTest extends BaseWebTestCase
{
    public function testCreate(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        /**
         * @var $entityManger EntityManagerInterface
         */
        $entityManger = static::getContainer()->get(EntityManagerInterface::class);

        $entityManger->persist(self::$user);
        $entityManger->flush();

        $client->loginUser(self::$user);

        // Act

        $client->request('POST', '/show-types', [
            'name' => 'New Test Show Type',
            'description' => 'A show type created for testing purposes',
            'isActive' => true,
        ]);

        $id = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/show-types/$id");

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals('New Test Show Type', $data['name']);
    }

    public function testCreateWithBadData(): void
    {
        // Arrange

        $client = static::createClient();

        $client->catchExceptions(false);
        $this->expectException(HttpException::class);

        $client->loginUser(self::$user);

        // Act

        $client->request('POST', '/show-types', [
            'name' => 'Another Test Show Type',
        ]);

        // Assert
        $this->assertResponseIsUnprocessable();
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

        $client->request('PUT', '/show-types/1', [
            'name' => 'Updated Show Type',
            'description' => 'An updated show type',
            'isActive' => false,
        ]);

        $client->request('GET', '/show-types/1');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $this->assertFalse($data['isActive']);
    }
}

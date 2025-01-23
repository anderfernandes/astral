<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TicketTypeTest extends BaseWebTestCase
{
    public function testCreateTicketType(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $entityManger EntityManagerInterface
         */
        $entityManger = static::getContainer()->get(EntityManagerInterface::class);

        $entityManger->persist(self::$user);
        $entityManger->flush();

        $client->loginUser(self::$user);

        /**
         * @var $normalizer DenormalizerInterface&NormalizerInterface
         */
        $normalizer = static::getContainer()->get(NormalizerInterface::class);

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $client->request('POST', '/ticket-types', [
            'name' => 'Test Ticket Type',
            'description' => 'A test ticket type to test event types',
            'price' => 500,
            'isActive' => true,
        ]);

        $id = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/ticket-types/$id");

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $this->assertEquals('Test Ticket Type', $data['name']);
    }

    public function testCreateTicketTypeWithBadData(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        // Act

        $client->request('POST', '/ticket-types', ['name' => 'Test']);

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testUpdateTicketType(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var $normalizer DenormalizerInterface&NormalizerInterface
         */
        $normalizer = static::getContainer()->get(NormalizerInterface::class);

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $client->request('PUT', '/ticket-types/1', [
            'name' => 'Updated Ticket Type',
            'description' => 'A test ticket type to test event types',
            'price' => 500,
            'isActive' => false,
        ]);

        $client->request('GET', '/ticket-types/1');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals('Updated Ticket Type', $data['name']);
    }

    public function testIndex(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $client->request('GET', '/ticket-types');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertCount(1, $data);
    }
}

<?php

namespace App\Tests\Application;

use App\Entity\TicketType;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EventTypeTest extends BaseWebTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /**
         * @var EntityManagerInterface $entityManger
         */
        $entityManger = static::getContainer()->get(EntityManagerInterface::class);

        $entityManger->persist(self::$user);

        $entityManger->persist(new TicketType(
            name: 'Test Ticket Type',
            description: 'A test ticket type to test event types',
            price: 500,
            creator: self::$user,
            isActive: true
        ));

        $entityManger->persist(new TicketType(
            name: 'Another Test Ticket Type',
            description: 'Another test ticket type to test event types',
            price: 700,
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

        $client->loginUser(self::$user);

        /**
         * @var DenormalizerInterface&NormalizerInterface&DecoderInterface $serializer
         */
        $serializer = static::getContainer()->get(NormalizerInterface::class);

        // Act

        $client->request('POST', '/event-types', [
            'name' => 'Test Event Type',
            'description' => 'Testing event types',
            'isActive' => true,
        ]);

        $id = $serializer->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/event-types/$id");

        $data = $serializer->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals('Test Event Type', $data['name']);
    }

    public function testIndex(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act
        $client->request('GET', '/event-types');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert
        $this->assertCount(1, $data);
    }

    public function testCreateEventTypeWithTicketType(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $client->request('POST', '/event-types', [
            'name' => 'Another Test Event Type',
            'description' => 'Testing event types, another',
            'isActive' => true,
            'ticketTypes' => [1, 2],
        ]);

        $id = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/event-types/$id");

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $this->assertCount(2, $data['ticketTypes']);
    }

    public function testCreateEventTypeWithBadData(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        $client->catchExceptions(false);
        $this->expectException(HttpException::class);

        // Act

        $client->request('POST', '/event-types', ['name' => 'Test']);

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testUpdateEventType(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $client->request('PUT', '/event-types/1', [
            'name' => 'Updated Event Type',
            'description' => 'Testing event types',
            'isActive' => true,
        ]);

        $client->request('GET', '/event-types/1');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals('Updated Event Type', $data['name']);
    }

    public function testEventUpdateClearingTicketTypes(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DenormalizerInterface&NormalizerInterface $normalizer
         */
        $normalizer = static::getContainer()->get(NormalizerInterface::class);

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $client->request('PUT', '/event-types/1', [
            'name' => 'Updated Event Type',
            'description' => 'Testing event types',
            'isActive' => true,
            'ticketTypes' => [],
        ]);

        $client->request('GET', '/event-types/1');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEmpty($data['ticketTypes']);
    }
}

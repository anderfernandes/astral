<?php

namespace App\Tests\Application;

use App\Entity\EventType;
use App\Entity\TicketType;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class TicketTypeTest extends BaseWebTestCase
{
    private array $ticketType;
    private array $eventTypes;

    public function setUp(): void
    {
        parent::setUp();

        $this->ticketType = [
            'name' => 'Test Ticket Type',
            'description' => 'A test ticket type',
            'price' => 500,
            'isActive' => 1,
            'isCashier' => rand(0, 1),
            'isPublic' => rand(0, 1),
        ];

        /**
         * @var $entityManager EntityManagerInterface
         */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $this->eventTypes[] = new EventType(
            name: 'Test Event Type',
            description: 'A test event type used to test allowed event types for a ticket',
            creator: $this->user,
        );

        $this->eventTypes[] = new EventType(
            name: 'Another Test Event Type',
            description: 'Another test event type used to test allowed event types for a ticket',
            creator: $this->user,
        );

        foreach ($this->eventTypes as $eventType) {
            $entityManager->persist($eventType);
        }

        $entityManager->flush();
    }

    public function testIndex(): void
    {
        $this->client->request('GET', 'ticket-types');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateTicketType(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/ticket-types', $this->ticketType);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateTicketTypeWithoutData(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/ticket-types', []);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testUpdateTicketType(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/ticket-types', $this->ticketType);

        $this->client->request('PUT', '/ticket-types/1', [
            ...$this->ticketType,
            'name' => 'Updated Ticket Type',
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateAndAddEventTypes(): void
    {
        $this->client->loginUser($this->user);

        /**
         * @var $serializer SerializerInterface
         */
        $serializer = static::getContainer()->get(SerializerInterface::class);

        $this->client->request('POST', '/ticket-types', [
            ...$this->ticketType,
            'eventTypes' => [2, 3],
        ]);

        $this->client->request('GET', '/ticket-types/3');

        dd($this->client->getResponse()->getContent());
    }
}

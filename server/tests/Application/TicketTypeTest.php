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
    public function testIndex(): void
    {
        $this->client->request('GET', 'ticket-types');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateTicketType(): void
    {
        /**
         * @var $serializer SerializerInterface
         */
        $serializer = static::getContainer()->get(SerializerInterface::class);

        $this->client->request('POST', '/ticket-types', $serializer->normalize($this->ticketTypes[0], 'json'));

        $this->assertResponseIsSuccessful();
    }

    public function testCreateTicketTypeWithoutData(): void
    {
        $this->client->request('POST', '/ticket-types', []);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testUpdateTicketType(): void
    {
        /**
         * @var $serializer SerializerInterface
         */
        $serializer = static::getContainer()->get(SerializerInterface::class);

        $this->client->request('POST', '/ticket-types', $serializer->normalize($this->ticketTypes[0], 'json'));

        $this->client->request('PUT', '/ticket-types/1', [
            ...$serializer->normalize($this->ticketTypes[0], 'json'),
            'name' => 'Updated Ticket Type',
        ]);

        $this->assertResponseIsSuccessful();
    }
}

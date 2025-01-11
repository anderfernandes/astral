<?php

namespace App\Tests\Application;

use App\Entity\Show;
use App\Model\EventDto;
use App\Repository\ShowTypeRepository;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class EventTest extends BaseWebTestCase
{
    private array $events;

    public function setUp(): void
    {
        parent::setUp();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $showTypesRepository = static::getContainer()->get(ShowTypeRepository::class);

        $entityManager->persist(
            new Show(
                name: 'Test Show',
                type: $showTypesRepository->find(1),
                duration: rand(15, 45),
                description: 'A random description for a test show',
                expiration: new \DateTime('+5 years'),
                isActive: rand(0, 1)
            )
        );

        $entityManager->persist(
            new Show(
                name: 'Another Test Show',
                type: $showTypesRepository->find(1),
                duration: rand(15, 45),
                description: 'Another random description for another test show',
                expiration: new \DateTime('+5 years'),
                isActive: rand(0, 1)
            )
        );

        $entityManager->flush();

        $starting = (new \DateTimeImmutable('+7 days'))->setTime(10, 30, 0);

        $eventB = new EventDto(
            starting: $starting->getTimestamp(),
            seats: rand(100, 200),
            typeId: 1,
            ending: $starting->add(\DateInterval::createFromDateString('1 hour'))->getTimestamp(),
            shows: [1],
            isPublic: rand(0, 1)
        );

        $this->events[] = new EventDto(
            starting: $starting->add(\DateInterval::createFromDateString('1 hour'))->getTimestamp(),
            seats: rand(100, 200),
            typeId: 1,
            ending: $starting->add(\DateInterval::createFromDateString('2 hours'))->getTimestamp(),
            shows: [2],
            isPublic: rand(0, 1)
        );

        $this->events[] = $eventB;
    }

    public function testCreateEvent(): void
    {
        $this->client->loginUser($this->user);

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $this->client->request('POST', '/events', [
            $serializer->normalize($this->events[0]),
        ]);

        $this->client->request('GET', '/events/1');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateMultipleEvents(): void
    {
        $this->client->loginUser($this->user);

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $this->client->request('POST', '/events', [
            $serializer->normalize($this->events[0]),
            $serializer->normalize($this->events[1]),
        ]);

        $this->client->request('GET', '/events/1');
        $this->client->request('GET', '/events/2');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateEventWithMultipleShows(): void
    {
        $this->client->loginUser($this->user);

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $this->events[0]->shows[1] = 2;

        $this->client->request('POST', '/events', [
            $serializer->normalize($this->events[0]),
        ]);

        $this->client->request('GET', '/events/1');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateMultipleEventsWithMultipleShows(): void
    {
        $this->client->loginUser($this->user);

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $this->events[0]->shows[1] = 2;
        $this->events[1]->shows[1] = 1;

        $this->client->request('POST', '/events', [
            $serializer->normalize($this->events[0]),
            $serializer->normalize($this->events[1]),
        ]);

        $this->client->request('GET', '/events/1');
        $this->client->request('GET', '/events/2');

        $this->assertResponseIsSuccessful();
    }
}

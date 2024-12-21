<?php

namespace App\Tests\Application;

use App\Entity\Event;
use App\Tests\BaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\SerializerInterface;

class EventTest extends BaseWebTestCase
{
    private array $event;

    public function setUp(): void
    {
        parent::setUp();

        $this->client->loginUser($this->user);

        $this->client->request('POST', '/shows', [
            'name' => 'Test Show',
            'typeId' => 1,
            'duration' => rand(15, 45),
            'description' => 'A random description for a show test',
            'isActive' => rand(0, 1),
            'trailerUrl' => \Faker\Factory::create()->url(),
            'expiration' => (new \DateTime('+5 years'))->format('c'),
        ]);

        $this->client->request('POST', '/shows', [
            'name' => 'Another Test Show',
            'typeId' => 1,
            'duration' => rand(15, 45),
            'description' => 'Another random description for a show test',
            'isActive' => rand(0, 1),
            'trailerUrl' => \Faker\Factory::create()->url(),
            'expiration' => (new \DateTime('+5 years'))->format('c'),
        ]);

        $starting = (new \DateTimeImmutable('+7 days'))->setTime(10, 0, 0);

        $this->event['starting'] = $starting->getTimestamp();
        $this->event['ending'] = $starting->add(\DateInterval::createFromDateString('1 hour'))->getTimestamp();
        $this->event['isPublic'] = true;
        $this->event['seats'] = random_int(100, 200);
        $this->event['typeId'] = $this->eventType->getId();
        $this->event['shows'] = [1];
    }

    public function testCreateEvent(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/events', $this->event);

        $id = json_decode($this->client->getResponse()->getContent())->data;

        $this->client->request('GET', "/events/$id");

        $this->assertResponseIsSuccessful();
    }

    public function testCreateEventWithMultipleShows(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/events', [
            ...$this->event,
            'shows' => [2, 1],
        ]);

        $id = json_decode($this->client->getResponse()->getContent())->data;

        $this->client->request('GET', "/events/$id");

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $event = $serializer->deserialize($this->client->getResponse()->getContent(), Event::class, 'json');

        $this->assertCount(2, $event->getShows());
    }

    public function testIndexWithoutStartOrEnd(): void
    {
        $this->client->loginUser($this->user);

        $date = (new \DateTimeImmutable())->setTime(10, 0, 0);
        $starting = $date->getTimestamp();
        $ending = $date->add(\DateInterval::createFromDateString('1 hour'))->getTimestamp();

        $this->client->request('POST', '/events', [
            ...$this->event,
            'starting' => $starting,
            'ending' => $ending,
        ]);

        $this->client->request('GET', '/events');

        $events = json_decode($this->client->getResponse()->getContent())->data;

        // $this->assertCount(1, $events);
        $this->assertEquals($date->format('c'), $events[0]->starting);
    }

    public function testIndexWithDatesThatReturnNoEvents(): void
    {
        $this->client->loginUser($this->user);

        $date = (new \DateTimeImmutable('+1 year'))->setTime(10, 0, 0);
        $starting = $date->getTimestamp();
        $ending = $date->add(\DateInterval::createFromDateString('1 hour'))->getTimestamp();

        $this->client->request('GET', "/events?start=$starting");

        $events = json_decode($this->client->getResponse()->getContent())->data;

        $this->assertCount(0, $events);
    }

    public function testShow(): void
    {
        $this->client->request('GET', '/events/1');

        $this->assertResponseIsSuccessful();
    }

    public function testShowWithEventThatDoesntExist(): void
    {
        $this->client->catchExceptions(false);
        $this->expectException(HttpException::class);

        $this->client->request('GET', '/events/99');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testUpdateEvent(): void
    {
        $date = (new \DateTimeImmutable())->setTime(10, 30, 0);

        $start = $date;
        $end = $date->add(\DateInterval::createFromDateString('1 hour'));

        /**
         * @var $serializer SerializerInterface
         */
        $serializer = static::getContainer()->get(SerializerInterface::class);

        $this->client->loginUser($this->user);

        $this->client->request('PUT', '/events/1', [
            ...$this->event,
            'starting' => $start->getTimestamp(),
            'ending' => $end->getTimestamp(),
        ]);

        $this->client->request('GET', '/events/1');

        $event = $serializer->deserialize($this->client->getResponse()->getContent(), Event::class, 'json');

        $this->assertEquals(
            [$start, $end],
            [$event->getStarting(), $event->getEnding()]
        );
    }
}

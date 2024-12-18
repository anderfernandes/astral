<?php

namespace App\Tests\Application;

use App\Entity\Event;
use App\Tests\BaseWebTestCase;
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

        $this->event['starting'] = $starting->format('c');
        $this->event['ending'] = $starting->add(\DateInterval::createFromDateString('1 hour'))->format('c');
        $this->event['isPublic'] = true;
        $this->event['seats'] = random_int(100, 200);
        $this->event['typeId'] = $this->eventType->getId();
        $this->event['shows'] = [1];
    }
    /*public function testCreateEvent(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/events', $this->event);

        $id = (json_decode($this->client->getResponse()->getContent()))->data;

        $this->client->request('GET', "/events/$id");

        $this->assertResponseIsSuccessful();
    }*/

    public function testCreateEventWithMultipleShows(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/events', [
            ...$this->event,
            'shows' => [2, 1]
        ]);

        $id = (json_decode($this->client->getResponse()->getContent()))->data;

        $this->client->request('GET', "/events/$id");

        $serializer = static::getContainer()->get(SerializerInterface::class);

        $event = $serializer->deserialize($this->client->getResponse()->getContent(), Event::class, 'json');

        $this->assertCount(2, $event->getShows());
    }
}
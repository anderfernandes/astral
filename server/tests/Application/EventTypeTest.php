<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EventTypeTest extends BaseWebTestCase
{
    private array $anotherEventType;

    public function setUp(): void
    {
        parent::setUp();

        $this->anotherEventType = [
            'name' => 'Another Event Type',
            'description' => 'The description for another event type',
            'color' => 'blue',
            'backgroundColor' => 'yellow',
            'isPublic' => false,
        ];
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/event-types');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateEventType(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/event-types', $this->anotherEventType);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateEventTypeWithTicketType(): void
    {
        $this->client->request('POST', '/event-types', [
            ...$this->anotherEventType,
            'eventTypes' => [1, 2]
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateEventTypeWithBadData(): void
    {
        $this->client->loginUser($this->user);

        $this->client->catchExceptions(false);
        $this->expectException(HttpException::class);

        $this->client->request('POST', '/event-types', []);
    }

    public function testEventTypeShow(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/event-types', $this->anotherEventType);

        $id = json_decode($this->client->getResponse()->getContent())->data;

        $this->client->request('GET', "/event-types/$id");

        $this->assertResponseIsSuccessful();
    }

    public function testEventTypeShowWithBadId(): void
    {
        $this->client->catchExceptions(false);
        $this->expectException(HttpException::class);

        $this->client->request('GET', '/event-types/99');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testEventUpdate(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('POST', '/event-types', $this->anotherEventType);

        $id = json_decode($this->client->getResponse()->getContent())->data;

        $this->client->request('PUT', "/event-types/$id", [
            ...$this->anotherEventType,
            'name' => 'Changed Event Type',
            'description' => 'Yet another changed event type',
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testEventUpdateWithBadData(): void
    {
        $this->client->loginUser($this->user);

        $this->client->catchExceptions(false);
        $this->expectException(HttpException::class);

        $this->client->request('POST', '/event-types', $this->anotherEventType);

        $id = json_decode($this->client->getResponse()->getContent())->data;

        $this->client->request('PUT', "/event-types/$id", []);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}

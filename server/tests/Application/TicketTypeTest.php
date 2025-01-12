<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;

class TicketTypeTest extends BaseWebTestCase
{
    private array $ticketType;

    public function setUp(): void
    {
        parent::setUp();

        $this->ticketType = [
            'name' => 'Test Ticket Type',
            'description' => 'A test ticket type',
            'price' => 500,
            'isActive' => rand(0, 1),
            'isCashier' => rand(0, 1),
            'isPublic' => rand(0, 1),
        ];
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

        $this->assertResponseIsSuccessful();
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
}

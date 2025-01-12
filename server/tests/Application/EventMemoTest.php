<?php

namespace App\Tests\Application;

use App\Entity\Event;
use App\Entity\Show;
use App\Repository\EventTypeRepository;
use App\Repository\ShowRepository;
use App\Repository\ShowTypeRepository;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class EventMemoTest extends BaseWebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var $eventTypes EventTypeRepository
         */
        $eventTypes = static::getContainer()->get(EventTypeRepository::class);

        /**
         * @var $showTypes ShowTypeRepository
         */
        $showTypes = static::getContainer()->get(ShowTypeRepository::class);

        /**
         * @var $shows ShowRepository
         */
        $shows = static::getContainer()->get(ShowRepository::class);

        /**
         * @var $entityManager EntityManagerInterface
         */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $entityManager->persist(new Show(
            name: 'Test Show',
            type: $showTypes->find(1),
            duration: rand(10, 50),
            description: 'A show created for testing purposes.'
        ));

        $entityManager->flush();

        $entityManager->persist(new Event(
            starting: (new \DateTime('+7 days'))->setTime(9, 30),
            ending: (new \DateTime('+7 days'))->setTime(10, 30),
            isPublic: rand(0, 1),
            seats: 100,
            type: $eventTypes->find(1),
            shows: [$shows->find(1)]
        ));

        $entityManager->flush();
    }

    public function testCreate()
    {
        $this->client->loginUser($this->user);

        $this->getClient()->request('POST', '/events/1/memos', [
            'content' => 'A test memo for a sale',
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateWithoutContent()
    {
        $this->client->loginUser($this->user);

        $this->getClient()->request('POST', '/events/1/memos', []);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCreateWithContentTooShort()
    {
        $this->client->loginUser($this->user);

        $this->getClient()->request('POST', '/events/1/memos', [
            'content' => 'ab',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCreateWithContentTooLong()
    {
        $this->client->loginUser($this->user);

        $this->getClient()->request('POST', '/events/1/memos', [
            'content' => \Faker\Factory::create()->realTextBetween(256, 512),
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

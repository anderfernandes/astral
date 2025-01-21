<?php

namespace App\Tests\Application;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Show;
use App\Entity\ShowType;
use App\Repository\EventTypeRepository;
use App\Repository\ShowRepository;
use App\Repository\ShowTypeRepository;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class EventMemoTest extends BaseWebTestCase
{
    public function testCreate(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        /**
         * @var $entityManger EntityManagerInterface
         */
        $entityManger = static::getContainer()->get(EntityManagerInterface::class);

        $entityManger->persist(self::$user);

        $showType = new ShowType(
            name: 'Test Show Type',
            description: 'A show type created for event tests',
            creator: self::$user,
            isActive: true
        );

        $entityManger->persist($showType);

        $shows[] = new Show(
            name: 'Test Show',
            type: $showType,
            duration: rand(15, 25),
            description: 'A test show made to test events',
            creator: self::$user,
            isActive: true,
        );

        $entityManger->persist($shows[0]);

        $eventType = new EventType(
            name: 'Test Event Type',
            description: 'Created to test events',
            creator: self::$user,
         );

        $entityManger->persist($eventType);

        $entityManger->persist(new Event(
            starting: (new \DateTime('+7 days'))->setTime(9, 30),
            ending: (new \DateTime('+7 days'))->setTime(10, 30),
            type: $eventType,
            creator: self::$user,
            isPublic: true,
            seats: rand(10, 180)
        ));

        $entityManger->flush();

        $client->loginUser(self::$user);

        // Act

        $client->request('POST', '/events/1/memos', [
            'content' => 'Testing event memos'
        ]);

        $client->request('GET', '/events/1');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json')['memos'][0];

        $this->assertEquals('Testing event memos', $data['content']);

    }
}

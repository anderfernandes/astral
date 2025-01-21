<?php

namespace App\Tests\Application;

use App\Entity\EventType;
use App\Entity\Show;
use App\Entity\ShowType;
use App\Model\EventDto;
use App\Repository\ShowTypeRepository;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class EventTest extends BaseWebTestCase
{
    public function testCreate(): void
    {
        // Arrange

        $client = static::createClient();

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

        $entityManger->persist(new EventType(
            name: 'Test Event Type',
            description: 'Created to test events',
            creator: self::$user,
         ));

        $entityManger->flush();

        $client->loginUser(self::$user);

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $starting = (new \DateTimeImmutable('+7 days'))->setTime(10, 30, 0);

        // Act

        $client->request('POST', '/events', [
            [
                'starting' => $starting->getTimestamp(),
                'ending' => $starting->add(\DateInterval::createFromDateString('1 hours'))->getTimestamp(),
                'seats' => rand(50, 180),
                'typeId' => 1,
                'shows' => [$shows[0]->getId()],
                'isPublic' => true,
            ]
        ]);

        $client->request('GET', '/events/1');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals($starting->format('c'), $data['starting']);
    }

    public function testUpdate(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->request('GET','/events/1');

        $starting = (new \DateTimeImmutable('+7 days'))->setTime(10, 30, 0);

        // Act

        $client->request('PUT', '/events/1', [
            'starting' => $starting->getTimestamp(),
            'ending' => $starting->add(\DateInterval::createFromDateString('1 hours'))->getTimestamp(),
            'seats' => 10,
            'typeId' => 1,
            'shows' => [1],
            'isPublic' => false,
            'memo' => 'A test memo for a test event'
        ]);

        $client->request('GET', '/events/1');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertFalse($data['isPublic']);
    }

    public function testIndex(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->request('GET', '/events');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json')['data'];

        $this->assertCount(1, $data);
    }
}

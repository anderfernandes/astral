<?php

namespace App\Tests\Application;

use App\Entity\EventType;
use App\Entity\Show;
use App\Entity\ShowType;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class EventTest extends BaseWebTestCase
{
    /**
     * @var $shows Show[]
     */
    static array $shows;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::bootKernel();

        /**
         * @var $entityManager EntityManagerInterface
         */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $entityManager->persist(self::$user);

        $showType = new ShowType(
            name: 'Test Show Type',
            description: 'A show type created for event tests',
            creator: self::$user,
            isActive: true
        );

        $entityManager->persist($showType);

        self::$shows[] = new Show(
            name: 'Test Show',
            type: $showType,
            duration: rand(15, 25),
            description: 'A test show made to test events',
            creator: self::$user,
            isActive: true,
        );

        $entityManager->persist(self::$shows[0]);

        $entityManager->persist(new EventType(
            name: 'Test Event Type',
            description: 'Created to test events',
            creator: self::$user,
        ));

        $entityManager->flush();

        self::ensureKernelShutdown();
    }

    public function testCreate(): void
    {
        // Arrange

        $client = static::createClient();

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
                'shows' => [self::$shows[0]->getId()],
                'isPublic' => true,
                'memo' => 'test memo',
            ],
        ]);

        $client->request('GET', '/events/1');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertCount(1, $data['memos']);
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

        $client->request('GET', '/events/1');

        $starting = (new \DateTimeImmutable('+7 days'))->setTime(10, 30, 0);

        // Act

        $client->request('PUT', '/events/1', [
            'starting' => $starting->getTimestamp(),
            'ending' => $starting->add(\DateInterval::createFromDateString('1 hours'))->getTimestamp(),
            'seats' => 10,
            'typeId' => 1,
            'shows' => [1],
            'isPublic' => false,
            'memo' => 'A test memo for a test event',
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

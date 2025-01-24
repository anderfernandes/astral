<?php

namespace App\Tests\Application;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Entity\Show;
use App\Entity\ShowType;
use App\Entity\TicketType;
use App\Enums\SaleSource;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SaleTest extends \App\Tests\BaseWebTestCase
{
    private static Event $event;

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

        $show = new Show(
            name: 'Test Show',
            type: $showType,
            duration: rand(15, 25),
            description: 'A test show made to test events',
            creator: self::$user,
            isActive: true,
        );

        $entityManager->persist($show);

        $eventType = new EventType(
            name: 'Test Event Type',
            description: 'Created to test sales',
            creator: self::$user,
         );

        $entityManager->persist($eventType);

        $ticketTypes[] = new TicketType(
            name: 'Test Ticket Type',
            description: 'A test ticket type to test sales',
            price: 600,
            creator: self::$user,
            isActive: true
            );

        $ticketTypes[] = new TicketType(
            name: 'Another Ticket Type',
            description: 'Another test ticket type to test sales',
            price: 700,
            creator: self::$user,
            isActive: true
         );

        foreach ($ticketTypes as $ticketType) {
            $entityManager->persist($ticketType);
            $eventType->addTicketType($ticketType);
        }

        self::$event = new Event(
            starting: (new \DateTime('+7 days'))->setTime(9, 30),
            ending: (new \DateTime('+7 days'))->setTime(10, 30),
            type: $eventType,
            creator: self::$user,
            seats: rand(50, 180),
        );

        self::$event->addShow($show);

        $entityManager->persist(self::$event);

        $entityManager->flush();

        self::ensureKernelShutdown();
    }

    public function testCreate(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var $serializer DenormalizerInterface&NormalizerInterface&DecoderInterface
         */
        $serializer = static::getContainer()->get(DenormalizerInterface::class);

        $client->loginUser(self::$user);

        // Act

        $sale = new Sale();

        foreach (self::$event->getType()->getTicketTypes() as $ticketType) {

            $name = self::$event->getId().' '.self::$event->getShows()->first()->getName().' '.self::$event->getType()->getName();

            $sale->addItem(new SaleItem(
                name: $name,
                description: $ticketType->getName(),
                price: $ticketType->getPrice(),
                quantity: rand(2, 10),
                cover: self::$event->getShows()->first()->getCover(),
                meta: ['eventId' => self::$event->getId(), 'ticketTypeId' => $ticketType->getId()]
           ));
        }

        //dd($normalizer->normalize($sale, 'json'));
        $client->request('POST', "/sales", $serializer->normalize($sale, 'json'));

        $id = $serializer->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/sales/$id");

        $data = $serializer->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertSameSize($sale->getItems(), $data['items']);
    }
}
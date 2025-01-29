<?php

namespace App\Tests\Application;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Entity\Show;
use App\Entity\ShowType;
use App\Entity\TicketType;
use App\Entity\User;
use App\Enums\PaymentMethodType;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SaleTest extends BaseWebTestCase
{
    public static Event $event;

    public static User $customer;

    /**
     * @var PaymentMethod[]
     */
    private static array $paymentMethods;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /**
         * @var EntityManagerInterface $entityManager
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

        self::$paymentMethods[] = new PaymentMethod(
            name: 'Cash',
            description: 'Cash payments',
            type: PaymentMethodType::CASH,
            creator: self::$user,
        );

        self::$paymentMethods[] = new PaymentMethod(
            name: 'Card',
            description: 'All debit and credit card payments',
            type: PaymentMethodType::CARD,
            creator: self::$user,
        );

        foreach (self::$paymentMethods as $paymentMethod) {
            $entityManager->persist($paymentMethod);
        }

        $faker = \Faker\Factory::create();

        self::$customer = new User(
            email: $faker->email(),
            firstName: $faker->firstName(),
            lastName: $faker->lastName(),
            password: password_hash($faker->password(), PASSWORD_DEFAULT)
        );

        $entityManager->persist(self::$customer);

        $entityManager->flush();

        self::ensureKernelShutdown();
    }

    public function testCreate(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var DenormalizerInterface&NormalizerInterface&DecoderInterface $serializer
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

        $payment = ['tendered' => $sale->getTotal(), 'methodId' => self::$paymentMethods[0]->getId()];

        $client->request('POST', '/sales', [
            ...$serializer->normalize($sale, 'json'),
            'payment' => $payment,
        ]);

        $id = $serializer->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/sales/$id");

        $data = $serializer->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals(
            ['itemsCount' => $sale->getItems()->count(), 'balance' => ($sale->getTotal() - $payment['tendered'])],
            ['itemsCount' => count($data['items']), 'balance' => $data['balance']]
        );
    }

    public function testCreateWithCustomer(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var DenormalizerInterface&NormalizerInterface&DecoderInterface $serializer
         */
        $serializer = static::getContainer()->get(DenormalizerInterface::class);

        $client->loginUser(self::$user);

        // Act

        $sale = new Sale(customer: self::$customer);

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

        $client->request('POST', '/sales', [
            ...$serializer->normalize($sale, 'json'),
            'payment' => ['tendered' => $sale->getTotal(), 'methodId' => self::$paymentMethods[0]->getId()],
        ]);

        $id = $serializer->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/sales/$id");

        $data = $serializer->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertSameSize($sale->getItems(), $data['items']);
    }

    public function testCreateWithCustomerWithoutPayment(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var DenormalizerInterface&NormalizerInterface&DecoderInterface $serializer
         */
        $serializer = static::getContainer()->get(DenormalizerInterface::class);

        $client->loginUser(self::$user);

        // Act

        $sale = new Sale(customer: self::$customer);

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

        $client->request('POST', '/sales', $serializer->normalize($sale, 'json'));

        // Assert

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testRefund(): void
    {
        // Arrange

        $client = static::createClient();

        /**
         * @var DenormalizerInterface&NormalizerInterface&DecoderInterface $serializer
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

        $payment = ['tendered' => $sale->getTotal(), 'methodId' => self::$paymentMethods[0]->getId()];

        $client->request('POST', '/sales', [
            ...$serializer->normalize($sale, 'json'),
            'payment' => $payment,
        ]);

        $id = $serializer->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('PUT', "/sales/$id?refund");

        $client->request('GET', "/sales/$id");

        $data = $serializer->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals(
            ['itemsCount' => $sale->getItems()->count(), 'balance' => ($sale->getBalance())],
            ['itemsCount' => count($data['items']), 'balance' => $data['balance']]
        );
    }
}

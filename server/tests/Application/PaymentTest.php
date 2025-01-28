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

class PaymentTest extends BaseWebTestCase
{
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

        $event = new Event(
            starting: (new \DateTime('+7 days'))->setTime(9, 30),
            ending: (new \DateTime('+7 days'))->setTime(10, 30),
            type: $eventType,
            creator: self::$user,
            seats: rand(50, 180),
        );

        $event->addShow($show);

        $entityManager->persist($event);

        $paymentMethods[] = new PaymentMethod(
            name: 'Cash',
            description: 'Cash payments',
            type: PaymentMethodType::CASH,
            creator: self::$user,
        );

        $paymentMethods[] = new PaymentMethod(
            name: 'Card',
            description: 'All debit and credit card payments',
            type: PaymentMethodType::CARD,
            creator: self::$user,
        );

        foreach ($paymentMethods as $paymentMethod) {
            $entityManager->persist($paymentMethod);
        }

        $faker = \Faker\Factory::create();

        $customer = new User(
            email: $faker->email(),
            firstName: $faker->firstName(),
            lastName: $faker->lastName(),
            password: password_hash($faker->password(), PASSWORD_DEFAULT)
        );

        $entityManager->persist($customer);

        $entityManager->flush();

        $sale = new Sale(creator: self::$user, customer: $customer);

        foreach ($event->getType()->getTicketTypes() as $ticketType) {
            $name = $event->getId().' '.$event->getShows()->first()->getName().' '.$event->getType()->getName();

            $item = new SaleItem(
                name: $name,
                description: $ticketType->getName(),
                price: $ticketType->getPrice(),
                quantity: rand(2, 10),
                cover: $event->getShows()->first()->getCover(),
                meta: ['eventId' => $event->getId(), 'ticketTypeId' => $ticketType->getId()]
            );

            $sale->addItem($item);

            $entityManager->persist($item);
        }

        $payment = new Payment(
            tendered: $sale->getTotal(),
            method: $paymentMethods[rand(0, count($paymentMethods) - 1)],
            cashier: self::$user,
            customer: $customer,
        );

        $sale->addPayment($payment);

        $entityManager->persist($payment);

        $entityManager->persist($sale);

        $entityManager->flush();

        self::ensureKernelShutdown();
    }

    public function testPaymentRefund(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        // Act
        $client->request('PUT', '/payments/1?refund');

        // Assert
        $this->assertResponseIsSuccessful();
    }
}

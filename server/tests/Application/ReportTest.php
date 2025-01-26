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
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class ReportTest extends BaseWebTestCase
{
    public static User $customer;

    public static Event $event;

    /**
     * @var Sale[]
     */
    public static array $sales;

    /**
     * @var User[]
     */
    public static array $cashiers;

    /**
     * @var PaymentMethod[]
     */
    public static array $paymentMethods;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

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

        self::$paymentMethods[] = new PaymentMethod(
            name: 'Cash',
            description: 'Cash payments',
            type: PaymentMethodType::Cash,
            creator: self::$user,
        );

        self::$paymentMethods[] = new PaymentMethod(
            name: 'Card',
            description: 'All debit and credit card payments',
            type: PaymentMethodType::Card,
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

        self::$cashiers[] = new User(
            email: $faker->email(),
            firstName: $faker->firstName(),
            lastName: $faker->lastName(),
            password: password_hash($faker->password(), PASSWORD_DEFAULT)
        );

        self::$cashiers[] = new User(
            email: $faker->email(),
            firstName: $faker->firstName(),
            lastName: $faker->lastName(),
            password: password_hash($faker->password(), PASSWORD_DEFAULT)
        );

        foreach (self::$cashiers as $cashier) {
            $entityManager->persist($cashier);
        }

        $entityManager->flush();

        foreach (self::$cashiers as $cashier) {
            $sale = new Sale(creator: $cashier, customer: self::$customer);

            foreach (self::$event->getType()->getTicketTypes() as $ticketType) {
                $name = self::$event->getId().' '.self::$event->getShows()->first()->getName().' '.self::$event->getType()->getName();

                $item = new SaleItem(
                    name: $name,
                    description: $ticketType->getName(),
                    price: $ticketType->getPrice(),
                    quantity: rand(2, 10),
                    cover: self::$event->getShows()->first()->getCover(),
                    meta: ['eventId' => self::$event->getId(), 'ticketTypeId' => $ticketType->getId()]
                );

                $sale->addItem($item);

                $entityManager->persist($item);
            }

            $payment = new Payment(
                tendered: $sale->getTotal(),
                method: self::$paymentMethods[0],
                cashier: $cashier,
                customer: self::$customer
            );

            $sale->addPayment($payment);

            $entityManager->persist($payment);

            $entityManager->persist($sale);

            self::$sales[] = $sale;

            $sale = new Sale(creator: $cashier, customer: self::$customer);

            foreach (self::$event->getType()->getTicketTypes() as $ticketType) {
                $name = self::$event->getId().' '.self::$event->getShows()->first()->getName().' '.self::$event->getType()->getName();

                $item = new SaleItem(
                    name: $name,
                    description: $ticketType->getName(),
                    price: $ticketType->getPrice(),
                    quantity: rand(2, 10),
                    cover: self::$event->getShows()->first()->getCover(),
                    meta: ['eventId' => self::$event->getId(), 'ticketTypeId' => $ticketType->getId()]
                );

                $sale->addItem($item);

                $entityManager->persist($item);
            }

            $payment = new Payment(
                tendered: $sale->getTotal(),
                method: self::$paymentMethods[1],
                cashier: $cashier,
                customer: self::$customer
            );

            $sale->addPayment($payment);

            $entityManager->persist($payment);

            $entityManager->persist($sale);

            self::$sales[] = $sale;
        }

        $entityManager->flush();

        self::ensureKernelShutdown();
    }

    public function testCloseout(): void
    {
        // Arrange
        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $start = self::$sales[0]->getCreatedAt()->setTime(0, 0)->getTimestamp();
        $end = self::$sales[0]->getCreatedAt()->setTime(0, 0)->modify('+1 day')->getTimestamp();
        $randomIndex = rand(0, count(self::$cashiers) - 1);
        $cashier = self::$cashiers[$randomIndex]->getId();

        $client->request('GET', "/reports/closeout?start=$start&end=$end&cashier=$cashier");

        // Assert

        $this->assertResponseIsSuccessful();
    }

    public function testCloseoutAllCashiers(): void
    {
        // Arrange
        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var $decoder DecoderInterface
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        // Act

        $start = self::$sales[0]->getCreatedAt()->setTime(0, 0)->getTimestamp();
        $end = self::$sales[0]->getCreatedAt()->setTime(0, 0)->modify('+1 day')->getTimestamp();

        $client->request('GET', "/reports/closeout?start=$start&end=$end");

        // Assert

        $this->assertResponseIsSuccessful();
    }
}

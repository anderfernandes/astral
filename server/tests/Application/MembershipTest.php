<?php

namespace App\Tests\Application;

use App\Entity\MembershipType;
use App\Entity\PaymentMethod;
use App\Entity\User;
use App\Enums\PaymentMethodType;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MembershipTest extends BaseWebTestCase
{
    /** @var MembershipType[] */
    public static array $membershipTypes = [];

    public static PaymentMethod $paymentMethod;

    public static User $secondary;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $entityManager->persist(self::$user);

        self::$membershipTypes[] = new MembershipType(
            name: 'Test Membership Type (no secondaries)',
            duration: 365,
            price: [2500, 3500][random_int(0, 1)],
        );

        self::$membershipTypes[] = new MembershipType(
            name: 'Another Test Membership Type (with secondaries)',
            duration: 365,
            price: [6000, 7500, 10000, 12500][random_int(0, 3)],
            paid_secondaries: random_int(1, 4),
            secondary_price: [2500, 3500][random_int(0, 1)],
        );

        foreach (self::$membershipTypes as $membershipType) {
            $entityManager->persist($membershipType);
        }

        self::$paymentMethod = new PaymentMethod(
            name: 'cash',
            description: 'cash',
            type: PaymentMethodType::CASH,
            creator: self::$user
        );

        $entityManager->persist(self::$paymentMethod);

        $faker = \Faker\Factory::create();

        self::$secondary = new User(
            email: $faker->email(),
            firstName: $faker->firstName(),
            lastName: $faker->lastName(),
            password: password_hash($faker->password(), PASSWORD_DEFAULT)
        );

        $entityManager->persist(self::$secondary);

        $entityManager->flush();

        self::ensureKernelShutdown();
    }

    public function testCreateAndShow(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DenormalizableInterface&NormalizerInterface&DecoderInterface $serializer
         */
        $serializer = static::getContainer()->get(NormalizerInterface::class);

        $tendered = self::$membershipTypes[0]->getPrice();
        $tendered += round($tendered * ((float) $_ENV['TAX'] / 100));

        $json = [
            'users' => [1],
            'type_id' => 1,
            'starting' => (new \DateTimeImmutable('+1 day'))->setTime(0, 0)->setTimezone(new \DateTimeZone('America/Chicago'))->format('c'),
            'payment' => [
                'methodId' => self::$paymentMethod->getId(),
                'tendered' => $tendered,
            ],
        ];

        $client->request('POST', '/memberships', $json);

        $id = $serializer->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/memberships/$id");

        $membership = $serializer->decode($client->getResponse()->getContent(), 'json');
        // dd($membership);
        $this->assertCount(count($json['users']), $membership['users']);
    }

    public function testCreateAndShowWithSecondary(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DenormalizableInterface&NormalizerInterface&DecoderInterface $serializer
         */
        $serializer = static::getContainer()->get(NormalizerInterface::class);

        $membershipType = self::$membershipTypes[1];

        $tendered = $membershipType->getPrice() + $membershipType->getSecondaryPrice();
        $tendered += round($tendered * ((float) $_ENV['TAX'] / 100));

        $json = [
            'users' => [1, 2],
            'type_id' => $membershipType->getId(),
            'starting' => (new \DateTimeImmutable('+1 day'))->setTime(0, 0)->setTimezone(new \DateTimeZone('America/Chicago'))->format('c'),
            'payment' => [
                'methodId' => self::$paymentMethod->getId(),
                'tendered' => $tendered,
            ],
        ];

        // Act

        $client->request('POST', '/memberships', $json);

        $id = $serializer->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/memberships/$id");

        $membership = $serializer->decode($client->getResponse()->getContent(), 'json');
        // dd($membership);

        // Assert

        $this->assertCount(count($json['users']), $membership['users']);
    }

    public function testCreateWithMembershipTypeThatTakesNoSecondaries(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DenormalizableInterface&NormalizerInterface&DecoderInterface $serializer
         */
        $serializer = static::getContainer()->get(NormalizerInterface::class);

        $membershipType = self::$membershipTypes[0];

        $tendered = $membershipType->getPrice() + $membershipType->getSecondaryPrice();
        $tendered += round($tendered * ((float) $_ENV['TAX'] / 100));

        $json = [
            'users' => [1, 2],
            'type_id' => $membershipType->getId(),
            'starting' => (new \DateTimeImmutable('+1 day'))->setTime(0, 0)->setTimezone(new \DateTimeZone('America/Chicago'))->format('c'),
            'payment' => [
                'methodId' => self::$paymentMethod->getId(),
                'tendered' => $tendered,
            ],
        ];

        // Act

        $client->request('POST', '/memberships', $json);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

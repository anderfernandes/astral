<?php

namespace App\Tests\Application;

use App\DataFixtures\AppFixtures;
use App\Entity\User;
use App\Tests\BaseWebTestCase;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class CartTest extends BaseWebTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::bootKernel();

        $loader = new Loader();
        $loader->addFixture(new AppFixtures(static::getContainer()->get('security.user_password_hasher')));

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = static::getContainer()->get(
            EntityManagerInterface::class
        );

        $executor = new ORMExecutor($entityManager, new ORMPurger());
        $executor->execute($loader->getFixtures());

        self::$user = $entityManager->getRepository(User::class)->findAll()[0];

        self::ensureKernelShutdown();
    }

    public function testShowWithEmptyCart(): void
    {
        $client = static::createClient();

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        $client->request('GET', '/cart');

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $this->assertEmpty($data);
    }

    public function testUpdateAddOne(): void
    {
        $client = static::createClient();

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        $meta = [
            'eventId' => 1, 'ticketTypeId' => 1,
        ];

        $client->request('POST', '/cart', $meta);

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $this->assertArrayHasKey('meta', $data[0]);
    }

    public function testUpdateAddTwoDifferentEvents(): void
    {
        $client = static::createClient();

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        $metaA = [
            'eventId' => 1, 'ticketTypeId' => 1,
        ];

        $client->request('POST', '/cart', $metaA);

        $metaB = [
            'eventId' => 2, 'ticketTypeId' => 2,
        ];

        $client->request('POST', '/cart', $metaB);

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $this->assertArrayHasKey('meta', $data[0]);
    }

    public function testUpdateRemoveOne(): void
    {
        $client = static::createClient();

        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        $client->request('POST', '/cart?remove=one', [
            'eventId' => 1, 'ticketTypeId' => 1,
        ]);

        $data = $decoder->decode($client->getResponse()->getContent(), 'json');

        $this->assertArrayHasKey('meta', $data[0]);
    }

    public function testShowWithItems(): void
    {
        $client = static::createClient();

        /**
         * @var DecoderInterface $decoder
         */
        $decoder = static::getContainer()->get(DecoderInterface::class);

        $client->loginUser(self::$user);

        $client->request('POST', '/cart', [
            'eventId' => 1, 'ticketTypeId' => 1,
        ]);

        $client->request('GET', '/cart');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}

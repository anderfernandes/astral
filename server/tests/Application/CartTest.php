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

        $data = $decoder->decode($client->getResponse()->getContent(), 'json')[
            'data'
        ];

        $this->assertEmpty($data);
    }

    public function testUpdate(): void
    {
        $client = static::createClient();

        $client->loginUser(self::$user);

        $client->request('POST', '/cart', [
            [
                'quantity' => 1,
                'meta' => ['eventId' => 1, 'ticketTypeId' => 1],
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
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
            [
                'meta' => ['eventId' => 1, 'ticketTypeId' => 1],
            ],
        ]);

        $client->request('GET', '/cart');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

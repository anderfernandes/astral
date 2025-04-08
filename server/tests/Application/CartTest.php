<?php

namespace App\Tests\Application;

use App\Entity\ShowType;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class CartTest extends BaseWebTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::bootKernel();

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = static::getContainer()->get(
            EntityManagerInterface::class
        );

        $entityManager->persist(self::$user);

        $entityManager->persist(
            new ShowType(
                name: 'Test Show Type',
                description: 'A show type created for event tests',
                creator: self::$user,
                isActive: true
            )
        );

        $entityManager->flush();

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

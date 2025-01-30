<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class PaymentMethodTest extends BaseWebTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $entityManager->persist(self::$user);

        $entityManager->flush();

        self::ensureKernelShutdown();
    }

    public function testCreate(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        // Act

        $client->request('POST', '/payment-methods', [
            'name' => 'Test Payment Type',
            'description' => 'A test payment type',
            'type' => 'other',
        ]);

        $id = json_decode($client->getResponse()->getContent())->data;

        // Assert

        $client->request('GET', "/payment-methods/$id}");

        $this->assertResponseIsSuccessful();
    }

    public function testUpdate(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DecoderInterface $serializer
         */
        $serializer = static::getContainer()->get(DecoderInterface::class);

        // Act

        $client->request('POST', '/payment-methods', [
            'name' => 'Updated Test Payment Type',
            'description' => 'An updated test payment type',
            'type' => 'check',
        ]);

        $id = json_decode($client->getResponse()->getContent())->data;

        // Assert

        $client->request('GET', "/payment-methods/$id}");

        $data = $serializer->decode($client->getResponse()->getContent(), 'json');

        $this->assertEquals(
            ['name' => 'Updated Test Payment Type', 'type' => 'check'],
            ['name' => $data['name'], 'type' => $data['type']]
        );
    }
}

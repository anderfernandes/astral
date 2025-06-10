<?php

namespace App\Tests\Application;

use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MembershipTypeTest extends BaseWebTestCase
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

    public function testCreateAndShow(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DenormalizerInterface&NormalizerInterface&DecoderInterface $serializer
         */
        $serializer = static::getContainer()->get(NormalizerInterface::class);

        // Act

        $membershipType = [
            'name' => 'Test Membership Type',
            'description' => 'A test membership type',
            'duration' => 365,
            'price' => 7500,
            'maxPaidSecondaries' => 1,
            'secondaryPrice' => 25,
        ];

        $client->request('POST', '/membership-types', $membershipType);

        $id = $serializer->decode($client->getResponse()->getContent(), 'json')['data'];

        $client->request('GET', "/membership-types/$id");

        $data = $serializer->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals($membershipType['name'], $data['name']);
    }

    public function testUpdate(): void
    {
        // Arrange

        $client = static::createClient();

        $client->loginUser(self::$user);

        /**
         * @var DenormalizerInterface&NormalizerInterface&DecoderInterface $serializer
         */
        $serializer = static::getContainer()->get(NormalizerInterface::class);

        // Act

        $client->request('PUT', '/membership-types/1', [
            'name' => 'Updated Test Membership',
        ]);

        $client->request('GET', '/membership-types/1');

        $data = $serializer->decode($client->getResponse()->getContent(), 'json');

        // Assert

        $this->assertEquals($data['name'], 'Updated Test Membership');
    }
}

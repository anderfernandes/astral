<?php

namespace App\Tests;

use App\Entity\EventType;
use App\Entity\ShowType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

abstract class BaseWebTestCase extends WebTestCase
{
    public User $user;

    public EventType $eventType;

    public KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $faker = \Faker\Factory::create();

        $user = new User();

        $user
            ->setEmail($faker->email())
            ->setPassword($faker->password())
            ->setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setAddress($faker->streetAddress())
            ->setCity('Austin')
            ->setState('Texas')
            ->setZip($faker->randomNumber(5))
            ->setCountry('United States of America')
            ->setPhone($faker->phoneNumber())
            ->setDateOfBirth(new \DateTimeImmutable())
            ->setIsActive(true);

        $showType = new ShowType;

        $showType
            ->setName('Test Show Type')
            ->setDescription('A show type created for testing purposes')
            ->setIsActive(true)
            ->setCreator($user);

        $eventType = new EventType();

        $eventType
            ->setName('Test Event Type')
            ->setDescription('An event type for testing purposes')
            ->setColor('white')
            ->setBackgroundColor('black')
            ->setIsPublic(true)
            ->setCreator($user);

        $this->client = static::createClient();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $entityManager->persist($user);
        $entityManager->persist($showType);
        $entityManager->persist($eventType);

        $entityManager->flush();

        $this->user = $user;
        $this->eventType = $eventType;
    }

    public static function tearDownAfterClass(): void
    {
        $filesystem = new Filesystem();

        $finder = new Finder();

        $files = [];

        $uploadsDir = __DIR__ . '/../public/uploads';

        foreach ($finder->files()->in($uploadsDir) as $file) {
            if ($file->getFilename() === 'default.png') continue;
            $files[] = $uploadsDir . '/' . $file->getFilename();
        }

        if (count($files) > 0)
            $filesystem->remove($files);

        //parent::tearDownAfterClass(); // TODO: Change the autogenerated stub
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Show;
use App\Entity\ShowType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User(email: 'test@test.com', firstName: 'Test', lastName: 'Tester');
        $user->setPassword($this->hasher->hashPassword($user, random_bytes(8)));
        $manager->persist($user);

        $showType = new ShowType(name: 'Test Show Type', creator: $user, description: 'A test show type');
        $manager->persist($showType);

        $show = new Show(
            name: 'Test Show',
            description: 'A test show',
            duration: random_int(25, 50),
            type: $showType,
            creator: $user
        );
        $manager->persist($show);

        $eventType = new EventType(name: 'Test Event Type', description: 'A test event type', creator: $user);
        $manager->persist($eventType);

        $event = new Event(
            starting: new \DateTime(),
            ending: new \DateTime(),
            type: $eventType,
            creator: $user,
            seats: random_int(9, 99),
            shows: [$show]
        );
        $manager->persist($event);

        $manager->flush();
    }
}

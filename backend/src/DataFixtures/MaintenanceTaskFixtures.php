<?php
// src/DataFixtures/MaintenanceTaskFixtures.php
namespace App\DataFixtures;

use App\Entity\MaintenanceTask;
use App\Enum\MaintenanceStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DateTimeImmutable;
use App\Entity\Room;

class MaintenanceTaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $room = $this->getReference('room_105', Room::class);
        $task = (new MaintenanceTask())
            ->setRoom($room)
            ->setTitle('Climatiseur à vérifier')
            ->setDescription('Ne refroidit pas assez')
            ->setStatus(MaintenanceStatus::OPEN)
            ->setCreatedAt(new DateTimeImmutable('-2 days'));
        $manager->persist($task);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [RoomFixtures::class];
    }
}

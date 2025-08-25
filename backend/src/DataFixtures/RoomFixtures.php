<?php
// src/DataFixtures/RoomFixtures.php
namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\RoomType;
use App\Enum\RoomStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RoomFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $rooms = [
            ['number' => '101', 'type' => 'rt_single', 'name' => 'Agoué',   'price' => '25000.00'],
            ['number' => '102', 'type' => 'rt_single', 'name' => 'Aného',   'price' => '25000.00'],
            ['number' => '103', 'type' => 'rt_double', 'name' => 'Atakpamé', 'price' => '35000.00'],
            ['number' => '104', 'type' => 'rt_double', 'name' => 'Kara',    'price' => '35000.00'],
            ['number' => '105', 'type' => 'rt_family', 'name' => 'Kpalimé', 'price' => '45000.00'],
            ['number' => '106', 'type' => 'rt_suite',  'name' => 'Lomé',    'price' => '65000.00'],
            ['number' => '201', 'type' => 'rt_single', 'name' => 'Sokodé',  'price' => '26000.00'],
            ['number' => '202', 'type' => 'rt_double', 'name' => 'Dapaong', 'price' => '36000.00'],
            ['number' => '203', 'type' => 'rt_family', 'name' => 'Mango',   'price' => '46000.00'],
            ['number' => '204', 'type' => 'rt_suite',  'name' => 'Bassari', 'price' => '70000.00'],
        ];

        foreach ($rooms as $r) {


            $roomType = $this->getReference($r['type'], RoomType::class);
            $room = (new Room())
                ->setNumber($r['number'])
                ->setName($r['name'])
                ->setType($roomType)
                ->setStatus(RoomStatus::AVAILABLE)
                ->setCapacityAdults(match ($r['type']) {
                    'rt_single' => 1,
                    'rt_double' => 2,
                    'rt_family' => 3,
                    'rt_suite'  => 2,
                    default => 2,
                })
                ->setCapacityChildren(match ($r['type']) {
                    'rt_family' => 2,
                    default => 0,
                })
                ->setNightPrice($r['price'])
                ->setCurrency('XOF');

            $manager->persist($room);
            $this->addReference('room_' . $r['number'], $room);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [RoomTypeFixtures::class];
    }
}

<?php
// src/DataFixtures/RoomTypeFixtures.php
namespace App\DataFixtures;

use App\Entity\RoomType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoomTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = [
            ['ref' => 'rt_single', 'name' => 'Single', 'desc' => 'Chambre simple'],
            ['ref' => 'rt_double', 'name' => 'Double', 'desc' => 'Pour 2 personnes'],
            ['ref' => 'rt_family', 'name' => 'Family', 'desc' => 'Idéale famille'],
            ['ref' => 'rt_suite',  'name' => 'Suite',  'desc' => 'Suite spacieuse'],
        ];

        foreach ($types as $t) {
            $rt = (new RoomType())
                ->setName($t['name'])
                ->setDescription($t['desc']);
            $manager->persist($rt);
            $this->addReference($t['ref'], $rt);
        }
        $manager->flush();
    }
}

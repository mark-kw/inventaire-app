<?php

namespace App\DataFixtures;


use App\Entity\Guest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;


class GuestFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create('fr_FR');
        $faker->seed(2025);


        for ($i = 0; $i < 12; $i++) {
            $g = (new Guest())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->optional()->safeEmail())
                ->setPhone($faker->optional()->e164PhoneNumber())
                ->setNationality($faker->randomElement(['Togo', 'Bénin', 'Ghana', 'France', 'Nigeria']))
                ->setIdType($faker->randomElement(['CNI', 'Passeport']))
                ->setIdNumber($faker->bothify('#######??'))
                ->setSpecialRequests($faker->optional(0.3)->sentence());
            $manager->persist($g);
            $this->addReference('guest_' . $i, $g);
        }
        $manager->flush();
    }
}

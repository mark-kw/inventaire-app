<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@exemple.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin123'));

        $employee = new User();
        $employee->setEmail('employe@exemple.com');
        $employee->setRoles(['ROLE_EMPLOYE']);
        $employee->setPassword($this->hasher->hashPassword($employee, 'employe123'));

        $manager->persist($admin);
        $manager->persist($employee);
        $manager->flush();
    }
}

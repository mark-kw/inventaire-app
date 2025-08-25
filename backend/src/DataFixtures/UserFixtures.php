<?php

namespace App\DataFixtures;


use App\Entity\User;
use App\Enum\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}


    public function load(ObjectManager $manager): void
    {
        $admin = (new User())
            ->setFullName('Admin Kafland')
            ->setEmail('admin@kafland.tg')
            ->setRole(UserRole::ADMIN);
        $admin->setPasswordHash($this->hasher->hashPassword($admin, 'admin'));
        $manager->persist($admin);
        $this->addReference('user_admin', $admin);


        $staff = (new User())
            ->setFullName('Reception Kafland')
            ->setEmail('staff@kafland.tg')
            ->setRole(UserRole::STAFF);
        $staff->setPasswordHash($this->hasher->hashPassword($staff, 'staff'));
        $manager->persist($staff);
        $this->addReference('user_staff', $staff);


        $manager->flush();
    }
}

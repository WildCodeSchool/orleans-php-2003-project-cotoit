<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $subscriber = new User();
        $subscriber->setUsername('CotoitUser');
        $subscriber->setRoles(['ROLE_USER']);
        $subscriber->setPassword($this->passwordEncoder->encodePassword(
            $subscriber,
            'Cotoitpassword'
        ));

        $manager->persist($subscriber);


        $admin = new User();
        $admin->setUsername('CotoitAdminUser');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'CotoitAdminpassword'
        ));

        $manager->persist($admin);

        $manager->flush();
    }
}

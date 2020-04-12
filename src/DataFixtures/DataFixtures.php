<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DataFixtures extends Fixture
{

    private $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;

    }

    public function load(ObjectManager $manager)
    {
        /*

        /
         * create user admin
         */
        $client1 = new User();

        $client1->setEmail('admin1@admin.fr');
        $hash = $this->encoder->encodePassword($client1, "test1");
        $client1->setPassword($hash);
        $client1->setRoles(["ROLE_USER"]);
        $manager->persist($client1);

        $client2 = new User();

        $client2->setEmail('admin2@admin.fr');
        $hash = $this->encoder->encodePassword($client2, "test2");
        $client2->setPassword($hash);
        $client2->setRoles(["ROLE_USER"]);
        $manager->persist($client2);

        $manager->flush();
    }
}

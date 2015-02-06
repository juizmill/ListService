<?php

namespace Application\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Application\Entity\User;

class UserLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * User load
     * @param  \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $user = new User;
        $user->setEmail('teste@gmail.com')
            ->setUserName('teste')
            ->setPassword('12345')
            ->setDisplayName('teste_display_name')
            ->setDescription('description_test');
        $manager->persist($user);

        $user2 = new User;
        $user2->setEmail('teste2@gmail.com')
            ->setUserName('teste2')
            ->setPassword('12345')
            ->setDisplayName('teste_display_name2')
            ->setDescription('description_test2');
        $manager->persist($user2);

        $user3 = new User;
        $user3->setEmail('teste3@gmail.com')
            ->setUserName('test3')
            ->setPassword('12345')
            ->setDisplayName('teste_display_name3')
            ->setDescription('description_test3');
        $manager->persist($user3);

        $manager->flush();
    }
    /**
    * @return int
    */
    public function getOrder()
    {
        return 3;
    }
}

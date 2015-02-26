<?php

namespace Application\Fixture;

use Application\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class UserLoad
 *
 * @package Application\Fixture
 */
class UserLoad extends AbstractFixture implements OrderedFixtureInterface
{
    // this constant conform passwordCost the ZfcUser\Options\ModuleOptions
    const PASSWORD_CONST = 14;

    /**
     * User load
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user->setEmail('teste@gmail.com')
            ->setUserName('teste')
            ->setPassword($this->encryptPassword('123456'))
            ->setDisplayName('teste_display_name');
        $manager->persist($user);

        $user2 = new User;
        $user2->setEmail('teste2@gmail.com')
            ->setUserName('teste2')
            ->setPassword($this->encryptPassword('123456'))
            ->setDisplayName('teste_display_name2');
        $manager->persist($user2);

        $user3 = new User;
        $user3->setEmail('teste3@gmail.com')
            ->setUserName('test3')
            ->setPassword($this->encryptPassword('123456'))
            ->setDisplayName('teste_display_name3');
        $manager->persist($user3);

        $manager->flush();

        $this->setReference('user1', $user);
        $this->setReference('user2', $user2);
        $this->setReference('user3', $user3);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * @param string $password
     * @return string
     */
    public function encryptPassword($password)
    {
        $bcrypt = new Bcrypt;
        $bcrypt->setCost(self::PASSWORD_CONST);
        return $bcrypt->create($password);
    }
}

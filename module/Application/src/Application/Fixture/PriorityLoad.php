<?php

namespace Application\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Application\Entity\Priority;

class PriorityLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Category load
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $priority = new Priority;
        $priority->setDescription('Upper')->setActive(true);
        $manager->persist($priority);

        $priority1 = new Priority;
        $priority1->setDescription('Lower')->setActive(true);
        $manager->persist($priority1);

        $priority2 = new Priority;
        $priority2->setDescription('Average')->setActive(true);
        $manager->persist($priority2);

        $manager->flush();
    }
    /**
    * @return int
    */
    public function getOrder()
    {
        return 2;
    }
}

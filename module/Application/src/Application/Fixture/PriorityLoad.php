<?php

namespace Application\Fixture;

use Application\Entity\Priority;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class PriorityLoad
 *
 * @package Application\Fixture
 */
class PriorityLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Category load
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
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

        $this->setReference('priority1', $priority);
        $this->setReference('priority2', $priority1);
        $this->setReference('priority3', $priority2);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}

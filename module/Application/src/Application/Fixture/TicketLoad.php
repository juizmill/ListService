<?php

namespace Application\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Application\Entity\Ticket;

class TicketLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Category load
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {

        $user = $manager->getReference('Application\Entity\User', 1);

        $ticket = new Ticket;
        $ticket->setSought('test_sought')
            ->setTitle('test_title')
            ->setUser($user);
        $manager->persist($ticket);

        $ticket1 = new Ticket;
        $ticket1->setSought('test_sought')
            ->setTitle('test_title')
            ->setUser($user);
        $manager->persist($ticket1);

        $ticket2 = new Ticket;
        $ticket2->setSought('test_sought')
            ->setTitle('test_title')
            ->setUser($user);
        $manager->persist($ticket2);

        $manager->flush();
    }
    /**
     * @return int
     */
    public function getOrder()
    {
        return 5;
    }
}

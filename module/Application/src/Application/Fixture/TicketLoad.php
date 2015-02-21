<?php

namespace Application\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Entity\Ticket;

/**
 * Class TicketLoad
 *
 * @package Application\Fixture
 */
class TicketLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Category load
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = $this->getReference('user1');

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

        $this->setReference('ticket1', $ticket);
        $this->setReference('ticket2', $ticket1);
        $this->setReference('ticket3', $ticket2);
    }
    /**
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }
}

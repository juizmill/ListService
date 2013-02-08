<?php

/**
 * Este arquivo é responsável por testar a manipulação de registro no banco de dados.
 * Onde o mesmo se refere a tabela ticket.
 * 
 * @author Jesus Vieira E-mail <jesusvieiradelima@gmail.com>
 * @package LSTicket\Fixture
 */

namespace LSTicket\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use LSTicket\Entity\Ticket;

class LoadTicket extends AbstractFixture implements OrderedFixtureInterface
{

  /**
   * Carrega o dispositivo de dados com o EntityManager
   * 
   * @param \Doctrine\Common\Persistence\ObjectManager $manager
   */
  public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
  {
    $categoryTicket = $manager->getReference('LSCategoryticket\Entity\CategoryTicket', 1);
    $priority = $manager->getReference('LSPriority\Entity\Priority', 1);
    $user = $manager->getReference('LSUser\Entity\User', 1);

    $ticket = new Ticket;
    $ticket->setTitle('Fixture titulo do Ticket')
            ->setSought('Jesus Vieira')
            ->setActive(true)
            ->setCategoryTicket($categoryTicket)
            ->setPriority($priority)
            ->setUser($user);
    $manager->persist($ticket);
    $manager->flush();
  }

  /**
   * Ordena a execução de cada Fixture
   * @return int
   */
  public function getOrder()
  {
    return 6;
  }

}
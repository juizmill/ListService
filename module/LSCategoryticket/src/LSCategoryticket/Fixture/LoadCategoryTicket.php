<?php

/**
 * Este arquivo é responsável por testar a manipulação de registro no banco de dados.
 * Onde o mesmo se refere a tabela category_ticket.
 * 
 * @author Jesus Vieira E-mail <jesusvieiradelima@gmail.com>
 * @package LSCategoryTicket\Fixture
 */

namespace LSCategoryticket\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use LSCategoryticket\Entity\CategoryTicket;

class LoadCategoryTicket extends AbstractFixture
{

  public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
  {
    $categoryTicket = new CategoryTicket;
    $categoryTicket->setDescription('Manutenção')->setActive(true);
    $manager->persist($categoryTicket);

    $categoryTicket1 = new CategoryTicket;
    $categoryTicket1->setDescription('Financeiro')->setActive(true);
    $manager->persist($categoryTicket1);

    $categoryTicket2 = new CategoryTicket;
    $categoryTicket2->setDescription('Orçamento')->setActive(true);
    $manager->persist($categoryTicket2);

    $categoryTicket3 = new CategoryTicket;
    $categoryTicket3->setDescription('Banner')->setActive(true);
    $manager->persist($categoryTicket3);

    $manager->flush();
  }

}

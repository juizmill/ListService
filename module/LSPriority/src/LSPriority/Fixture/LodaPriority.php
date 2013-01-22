<?php

/**
 * Este arquivo é responsável por testar a manipulação de registro no banco de dados.
 * Onde o mesmo se refere a tabela priority.
 * 
 * @author Jesus Vieira E-mail <jesusvieiradelima@gmail.com>
 * @package LSCategoryTicket\Fixture
 */

namespace LSPriority\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use LSPriority\Entity\Priority;

class LodaPriority extends AbstractFixture
{

  /**
   * Carrega o dispositivo de dados com o EntityManager
   * 
   * @param \Doctrine\Common\Persistence\ObjectManager $manager
   */
  public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
  {
    $priority = new Priority;
    $priority->setDescription('Alta')->setActive(true);
    $manager->persist($priority);

    $priority1 = new Priority;
    $priority1->setDescription('Baixa')->setActive(true);
    $manager->persist($priority1);

    $priority2 = new Priority;
    $priority2->setDescription('Média')->setActive(true);
    $manager->persist($priority2);

    $manager->flush();
  }

}
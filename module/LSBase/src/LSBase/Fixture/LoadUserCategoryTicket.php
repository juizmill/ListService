<?php

/**
 * Este arquivo é responsável por testar a manipulação de registro no banco de dados.
 * Onde o mesmo se refere a tabela user_category_ticket.
 * 
 * @author Jesus Vieira E-mail <jesusvieiradelima@gmail.com>
 * @package LSBase\Fixture
 */

namespace LSBase\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use LSBase\Entity\UserCategoryTicket;

class LoadUserCategoryTicket extends AbstractFixture implements OrderedFixtureInterface
{

  /**
   * Carrega o dispositivo de dados com o EntityManager
   * 
   * @param \Doctrine\Common\Persistence\ObjectManager $manager
   */
  public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
  {
    
    $user = $manager->getReference('LSUser\Entity\User', 1);
    $categoryTicket1 = $manager->getReference('LSCategoryticket\Entity\CategoryTicket', 1);
    $categoryTicket2 = $manager->getReference('LSCategoryticket\Entity\CategoryTicket', 2);
    $categoryTicket3 = $manager->getReference('LSCategoryticket\Entity\CategoryTicket', 3);
    $categoryTicket4 = $manager->getReference('LSCategoryticket\Entity\CategoryTicket', 4);

    $userCategoryTicket = new UserCategoryTicket;
    $userCategoryTicket->setUser($user)
            ->setCategoryTicket($categoryTicket1);
    $manager->persist($userCategoryTicket);

    $userCategoryTicket1 = new UserCategoryTicket;
    $userCategoryTicket1->setUser($user)
            ->setCategoryTicket($categoryTicket2);
    $manager->persist($userCategoryTicket1);

    $userCategoryTicket2 = new UserCategoryTicket;
    $userCategoryTicket2->setUser($user)
            ->setCategoryTicket($categoryTicket3);
    $manager->persist($userCategoryTicket2);

    $userCategoryTicket3 = new UserCategoryTicket;
    $userCategoryTicket3->setUser($user)
            ->setCategoryTicket($categoryTicket4);
    $manager->persist($userCategoryTicket3);

    $manager->flush();
  }

  /**
   * Ordena a execução de cada Fixture
   * @return int
   */
  public function getOrder()
  {
    return 5;
  }

}
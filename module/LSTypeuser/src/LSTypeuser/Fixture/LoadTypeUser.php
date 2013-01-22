<?php

/**
 * Este arquivo é responsável por testar a manipulação de registro no banco de dados.
 * Onde o mesmo se refere a tabela type_user.
 * 
 * @author Jesus Vieira E-mail <jesusvieiradelima@gmail.com>
 * @package LSTypeuser\Fixture
 */

namespace LSTypeuser\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use LSTypeuser\Entity\TypeUser;

class LoadTypeUser extends AbstractFixture
{

  /**
   * Carrega o dispositivo de dados com o EntityManager
   * 
   * @param \Doctrine\Common\Persistence\ObjectManager $manager
   */
  public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
  {
    $typeUser = new TypeUser;
    $typeUser->setDescription('Administrador')->setActive(true);
    $manager->persist($typeUser);

    $typeUser1 = new TypeUser;
    $typeUser1->setDescription('Agente')->setActive(true);
    $manager->persist($typeUser1);

    $typeUser2 = new TypeUser;
    $typeUser2->setDescription('Cliente')->setActive(true);
    $manager->persist($typeUser2);


    $manager->flush();
  }

}

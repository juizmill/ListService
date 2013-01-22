<?php

/**
 * Este arquivo é responsável por testar a manipulação de registro no banco de dados.
 * Onde o mesmo se refere a tabela user.
 * 
 * @author Jesus Vieira E-mail <jesusvieiradelima@gmail.com>
 * @package LSUser\Fixture
 */

namespace LSUser\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use LSUser\Entity\User;

class LoadUser extends AbstractFixture
{

  /**
   * Carrega o dispositivo de dados com o EntityManager
   * 
   * @param \Doctrine\Common\Persistence\ObjectManager $manager
   */
  public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
  {
    $typeUser = $manager->getReference('LSTypeuser\Entity\TypeUser', 1);

    $use = new User;
    $use->setName('ListService')
            ->setLogin('listservice')
            ->setPassword('12345')
            ->setImage('qwehg98w798ga89sga0s.jpg')
            ->setActive(true)
            ->setTypeUse($typeUser);
    $manager->persist($use);
    $manager->flush();
  }

}
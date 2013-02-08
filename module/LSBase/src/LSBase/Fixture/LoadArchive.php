<?php

/**
 * Este arquivo é responsável por testar a manipulação de registro no banco de dados.
 * Onde o mesmo se refere a tabela archive.
 * 
 * @author Jesus Vieira E-mail <jesusvieiradelima@gmail.com>
 * @package LSBase\Fixture
 */

namespace LSBase\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use LSBase\Entity\Archive;

class LoadArchive extends AbstractFixture implements OrderedFixtureInterface
{

  /**
   * Carrega o dispositivo de dados com o EntityManager
   * 
   * @param \Doctrine\Common\Persistence\ObjectManager $manager
   */
  public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
  {
    $interaction = $manager->getReference('LSInteraction\Entity\Interaction', 1);

    $archive = new Archive;
    $archive->setIntereaction($interaction)
            ->setPathFile('Caminhgo_da_imagem_ou_arquivo');
    $manager->persist($archive);
    $manager->flush();
  }

  /**
   * Ordena a execução de cada Fixture
   * @return int
   */
  public function getOrder()
  {
    return 8;
  }

}
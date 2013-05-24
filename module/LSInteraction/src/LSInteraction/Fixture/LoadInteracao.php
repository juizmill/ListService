<?php

/**
 * Este arquivo é responsável por testar a manipulação de registro no banco de dados.
 * Onde o mesmo se refere a tabela interaction.
 *
 * @author Jesus Vieira E-mail <jesusvieiradelima@gmail.com>
 * @package LSInteraction\Fixture
 */

namespace LSInteraction\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use LSInteraction\Entity\Interaction;

class LoadInteracao extends AbstractFixture implements OrderedFixtureInterface
{

  /**
   * Carrega o dispositivo de dados com o EntityManager
   *
   * @param \Doctrine\Common\Persistence\ObjectManager $manager
   */
  public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
  {
    $user = $manager->getReference('LSUser\Entity\User', 1);
    $ticket = $manager->getReference('LSTicket\Entity\Ticket', 1);

    $interaction = new Interaction();
    $interaction->setDescription('Mussum ipsum cacilds, vidis litro abertis.
                                  Consetis adipiscings elitis. Pra lá , depois
                                  divoltis porris, paradis. Paisis, filhis,
                                  espiritis santis. Mé faiz elementum girarzis,
                                  nisi eros vermeio, in elementis mé pra quem é
                                  amistosis quis leo. Manduma pindureta quium dia
                                  nois paga. Sapien in monti palavris qui num
                                  significa nadis i pareci latim. Interessantiss
                                  quisso pudia ce receita de bolis, mais bolis eu num gostis.')
            ->setTicket($ticket)
            ->setUser($user);
    $manager->persist($interaction);
    $manager->flush();

  }

  /**
   * Ordena a execução de cada Fixture
   * @return int
   */
  public function getOrder()
  {
    return 7;
  }

}

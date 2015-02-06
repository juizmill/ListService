<?php

namespace Application\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Application\Entity\Interaction;

class InteractionLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Interaction load
     * @param  \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $user = $manager->getReference('Application\Entity\User', 1);
        //$ticket = $manager->getReference('LSTicket\Entity\Ticket', 1);
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
          //      ->setTicket($ticket)
                ->setUser($user);
        $manager->persist($interaction);
        $manager->flush();
    }
    /**
    * @return int
    */
    public function getOrder()
    {
        return 4;
    }
}

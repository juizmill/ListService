<?php
namespace LSTicket\Service;

use Doctrine\ORM\EntityManager;

use LSBase\Service\AbstractService;
use LSInteraction\Entity\Interaction;

/**
 * Ticket
 *
 * Classe Service Ticket
 *
 * @package LSTicket\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class Ticket extends AbstractService
{
  public function __construct(EntityManager $em)
  {
    parent::__construct($em);
    $this->entity = 'LSTicket\Entity\Ticket';
  }

    /**
     * insert
     *
     * Insere um registro.
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @param array $data
     * @access public
     * @return $entity
     */
    public function insert(array $data)
    {

        $categoryTicket = $this->em->getReference('LSCategoryticket\Entity\CategoryTicket', $data['categoryTicket']);
        $user = $this->em->getReference('LSUser\Entity\User', 1);

        if (get_class($categoryTicket) == 'LSCategoryticket\\Entity\\CategoryTicket') {

            $data['categoryTicket'] = $categoryTicket;
            $data['user'] = $user;

            $ticket = parent::insert($data);

            $interaction = new Interaction(array(
                'description' => $data['description'],
                'ticket' => $ticket,
                'user' => $user)
            );

            $this->em->persist($interaction);
            $this->em->flush($interaction);






            return $ticket;

        } else {
            return false;
        }
    }
}
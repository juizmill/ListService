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

        if (get_class($categoryTicket) == 'LSCategoryticket\\Entity\\CategoryTicket') {

            $data['categoryTicket'] = $categoryTicket;

            return parent::insert($data);

        } else {
            return false;
        }
    }

    /**
     * update
     *
     * Atualiza um registro
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @param array $data
     * @access public
     * @return $entity
     */
    public function update(array $data)
    {
        $ticket = $this->em->getRepository($this->entity)->find($data['id']);

        if ($ticket) {

            $data['categoryTicket'] = $ticket->getCategoryTicket();
            $data['dateEstimated'] = new \DateTime($data['date']);
            unset($data['date']);

            return parent::update($data);

        } else {
            return false;
        }
    }

    /**
     * update
     *
     * Atualiza um registro
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @param array $data
     * @access public
     * @return $entity
     */
    public function updateActive(array $data)
    {
        $ticket = $this->em->getRepository($this->entity)->find($data['id']);

        if ($ticket) {

            $data['categoryTicket'] = $ticket->getCategoryTicket();

            return parent::update($data);

        } else {
            return false;
        }
    }

    /**
     * updateUser
     *
     * Atualiza um registro
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @param array $data
     * @access public
     * @return $entity
     */
    public function updateUser(array $data)
    {

        $ticket = $this->em->getRepository($this->entity)->find($data['id']);

        if ($ticket) {

            $user = $this->em->getRepository("LSUser\Entity\User")->find($data['agente']);

            $data['user'] = $user;

            return parent::update($data);

        } else {
            return false;
        }
    }





}
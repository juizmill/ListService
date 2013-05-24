<?php
namespace LSBase\Service;

use Doctrine\ORM\EntityManager;

use LSBase\Service\AbstractService;

/**
 * CategoryTicketUser
 *
 * Classe Service CategoryTicketUser
 *
 * @package LSBase\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class CategoryTicketUser extends AbstractService
{
  public function __construct(EntityManager $em)
  {
    parent::__construct($em);
    $this->entity = 'LSBase\Entity\UserCategoryTicket';
  }

  /**
   * insertAndUpdate
   *
   * Insere ou deleta um registro.
   *
   * @author Jesus Vieira <jesusvieiradelima@gmail.com>
   * @param array $data
   * @access public
   */
  public function insertAndUpdate(array $data)
  {

    $entity         = $this->em->getRepository('LSBase\Entity\UserCategoryTicket')->findBy(array('user' => $data['user'], 'categoryTicket' => $data['categoryTicket']));

    $categoryTicket = $this->em->getRepository('LSCategoryticket\Entity\CategoryTicket')->findBy(array('id' => $data['categoryTicket']));
    $user           = $this->em->getRepository('LSUser\Entity\User')->findBy(array('id' =>  $data['user']));

    if ($entity) {
        return parent::delete($entity[0]->getId());
    } else {

        if ($categoryTicket[0] && $user[0]) {

            $data['user']           = $user[0];
            $data['categoryTicket'] = $categoryTicket[0];

            return parent::insert($data);

        } else { return false;}

    }
  }
}

<?php
namespace LSTicket\Service;

use Doctrine\ORM\EntityManager;

use LSBase\Service\AbstractService;

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
}
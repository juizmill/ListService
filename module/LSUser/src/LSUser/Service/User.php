<?php
namespace LSUser\Service;

use Doctrine\ORM\EntityManager;

use LSBase\Service\AbstractService;

/**
 * User
 *
 * Classe Service User
 *
 * @package LSUser\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class User extends AbstractService
{
  public function __construct(EntityManager $em)
  {
    parent::__construct($em);
    $this->entity = 'LSUser\Entity\User';
  }
}
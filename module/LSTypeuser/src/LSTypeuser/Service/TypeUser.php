<?php
namespace LSTypeuser\Service;

use Doctrine\ORM\EntityManager;

use SOBase\Service\AbstractService;

/**
 * TypeUser
 *
 * Classe Service TypeUser
 *
 * @package LSTypeuser\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class TypeUser extends AbstractService
{
  public function __construct(EntityManager $em)
  {
    parent::__construct($em);
    $this->entity = 'LSTypeuser\Entity\TypeUser';
  }
}
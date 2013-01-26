<?php
namespace LSInteraction\Service;

use Doctrine\ORM\EntityManager;

use LSBase\Service\AbstractService;

/**
 * Interaction
 *
 * Classe Service Interaction
 *
 * @package LSInteraction\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class Interaction extends AbstractService
{
  public function __construct(EntityManager $em)
  {
    parent::__construct($em);
    $this->entity = 'LSInteraction\Entity\Interaction';
  }
}
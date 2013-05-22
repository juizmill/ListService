<?php
namespace LSPriority\Service;

use Doctrine\ORM\EntityManager;

use LSBase\Service\AbstractService;

/**
 * Priority
 *
 * Classe Service Priority
 *
 * @package LSPriority\Service
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class Priority extends AbstractService
{
  public function __construct(EntityManager $em)
  {
    parent::__construct($em);
    $this->entity = 'LSPriority\Entity\Priority';
  }
}